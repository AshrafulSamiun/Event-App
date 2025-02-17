<?php

namespace App\Http\Controllers\OperatingModule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\FormEntry;
use Illuminate\Support\Facades\DB;

class FormEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ArrayFunction                  =new ArrayFunction();
        $form_type_arr                  =$ArrayFunction->form_type_arr;
        $form_priority_level_arr        =$ArrayFunction->form_priority_level_arr;
        $data['form_type_arr']          =$form_type_arr;
        $data['form_priority_level_arr']          =$form_priority_level_arr;

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function FormEntryList( Request $request)
    {

        $user=\Auth::user();
        $project_id                     = $user->project_id;
        $ArrayFunction                  =new ArrayFunction();
        $form_type_arr                  =$ArrayFunction->form_type_arr;
        $form_priority_level_arr        =$ArrayFunction->form_priority_level_arr;
        
        //===================Building==========================================

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }

        $sl=0;
        $form_entry_list=FormEntry::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->get();

        $data['form_entry_list']=array();
        foreach ($form_entry_list as $key => $value) {

            $data['form_entry_list'][$key]['sl']                   =$sl+1;
            $data['form_entry_list'][$key]['id']                   =$value->id;
            $data['form_entry_list'][$key]['form_no']              =$value->form_no;
            $data['form_entry_list'][$key]['form_type']            =$value->form_type;
            $data['form_entry_list'][$key]['priority_level']       =$value->priority_level;
            $data['form_entry_list'][$key]['form_type_string']     =$form_type_arr[$value->priority_level];
            $data['form_entry_list'][$key]['priority_level_string']=$form_priority_level_arr[$value->priority_level];
            $data['form_entry_list'][$key]['form_date']            =date("D M d, Y",strtotime($request->input('form_date')));
            $data['form_entry_list'][$key]['from_department']      =$value->from_department;
            $data['form_entry_list'][$key]['from_id_name']         =$value->from_id_name;
            $data['form_entry_list'][$key]['to_department']        =$value->to_department;
            $data['form_entry_list'][$key]['to_id_name']           =$value->to_id_name;
            $data['form_entry_list'][$key]['subject']              =$value->subject;
            $data['form_entry_list'][$key]['posting_status']       =$value->posting_status;
            $data['form_entry_list'][$key]['next_step']            =$value->next_step;
            $sl++;

        }
        
        return $data;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
        request()->validate([
            'form_date'                     => 'required',
            'form_type'                     => 'required',
            'priority_level'                => 'required',
            'subject'                       => 'required',
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $form_type=$request->input('form_type');
        $form_date                    =date("Y-m-d",strtotime($request->input('form_date')));
        $request->merge(['form_date'         =>$form_date]);
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);


        $company_id="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return; 
        }

        $request->merge(['company_id' =>$company_id]);
        

        $max_system_data = FormEntry::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from form_entries where project_id=".$project_id."   and company_id=".$company_id.") and company_id=".$company_id."  and project_id=".$project_id)->get(['system_prefix']);

               
       
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no=$form_type."-".str_pad($max_system_prefix, 5, 0, STR_PAD_LEFT);

        $request->merge(['form_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $sales_offer_info= FormEntry::create($request->all());


        if($sales_offer_info)
        {
           DB::commit();
           return "1**$sales_offer_info->id**$system_no";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;


        $ArrayFunction              =new ArrayFunction();
        $additional_charge_arr      =$ArrayFunction->additional_charge_arr;
        $deduction_charge_arr       =$ArrayFunction->deduction_charge_arr;
        
       

        $sl=0;
        foreach ($additional_charge_arr as $key => $value) {
            $data['additional_charge_arr'][$sl]['id']=$key;
            $data['additional_charge_arr'][$sl]['value']=$value;
            $sl++;
        }

        $sl=0;
        foreach ($deduction_charge_arr as $key => $value) {
            $data['deduction_charge_arr'][$sl]['id']=$key;
            $data['deduction_charge_arr'][$sl]['value']=$value;
            $sl++;
        }


        //===================Company==========================================
        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
        }
        $service_provider           =AccountHolder::where('status_active',1)
                                            ->where('project_id',$project_id)
                                            ->get();        

        //===================Building==========================================

        $account_holder_list=array();
        foreach ($service_provider as $key => $value) {
            //$account_holder_list[$value->id]=$value->first_name." ".$value->middle_name." ".$value->last_name;
            $account_holder_list[$value->id]=$value;
        }

        $sl=0;
        $sales_offer_list=Sale::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('entry_form',1)
                                        ->where('id',$id)
                                       // ->where('company_type',$company_type)
                                        ->get();

        $data['sales_offer_list']=array();
        foreach ($sales_offer_list as $key => $value) {

            $data['sales_offer_list']['id']                              =$value->id;
            $data['sales_offer_list']['unique_no']                       =$value->unique_no;
            $data['sales_offer_list']['transaction_no']                  =$value->transaction_no;
            $data['sales_offer_list']['sales_offer_no']               =$value->transaction_no;

            $data['sales_offer_list']['sales_type']                   =$value->sales_type;
            $data['sales_offer_list']['schedule_delivery_date']          =$value->schedule_delivery_date;            
            $data['sales_offer_list']['approval_status']                 =$value->approval_status;

            $data['sales_offer_list']['schedule_delivery_date']          =date("Y-m-d",strtotime($value->schedule_delivery_date));
            $data['sales_offer_list']['schdule_delivery_time']           =date("h:i:s",strtotime($value->schedule_delivery_date));
            $data['sales_offer_list']['sales_offer_date']             =date("D M d, Y",strtotime($value->created_at));
            $data['sales_offer_list']['delivery_location']               =$value->delivery_location;
            $data['sales_offer_list']['delivery_instruction']            =$value->delivery_instruction;
            $data['sales_offer_list']['delivery_contact_person_name']    =$value->delivery_contact_person_name;            
            $data['sales_offer_list']['delivery_contact_person_email']   =$value->delivery_contact_person_email;

            $data['sales_offer_list']['delivery_contact_person_phone']   =$value->delivery_contact_person_phone;
            $data['sales_offer_list']['delivery_receive_by']             =$value->delivery_receive_by;
            $data['sales_offer_list']['payment_due_date']                =$value->payment_due_date;
            $data['sales_offer_list']['payment_method']                  =$value->payment_method;
            $data['sales_offer_list']['days_left_to_pay']                =$value->days_left_to_pay;
            $data['sales_offer_list']['early_payment_discount']          =$value->early_payment_discount;            
            $data['sales_offer_list']['posted_check_available']          =$value->posted_check_available;

            $data['sales_offer_list']['late_payment_pelanty']            =$value->late_payment_pelanty;
            $data['sales_offer_list']['hidden_cost']                     =$value->hidden_cost;
            $data['sales_offer_list']['shipping_cost_pay_by']            =$value->shipping_cost_pay_by;
            $data['sales_offer_list']['payment_status']                  =$value->payment_status;
            $data['sales_offer_list']['posting_status']                  =$value->posting_status;
            $data['sales_offer_list']['next_step']                       =$value->next_step;


            $data['sales_offer_list']['sales_offer_acceptance_no']    ="";
            $data['sales_offer_list']['sales_offer_acceptance_date']  ="";
            $data['sales_offer_list']['sales_order_date']             ="";
            $data['sales_offer_list']['sales_order_no']               ="";
            $data['sales_offer_list']['packing_slip_date']               ="";
            $data['sales_offer_list']['packing_slip_no']                 ="";
            $data['sales_offer_list']['sales_return_date']            ="";
            $data['sales_offer_list']['sales_return_no']              ="";
            $data['sales_offer_list']['sales_credit_note_date']       ="";
            $data['sales_offer_list']['sales_credit_note_no']         ="";

            $data['sales_offer_list']['sales_invoice_date']           ="";
            $data['sales_offer_list']['sales_invoice_no']             ="";
            $data['sales_offer_list']['sales_debit_note_date']        ="";
            $data['sales_offer_list']['sales_debit_note_no']          ="";
            $sales_list=Sale::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('entry_form',"!=",1)
                                        ->where('unique_no',$value->unique_no)
                                        ->get();

            //dd($sales_list);
            foreach($sales_list as $val)
            {
                if($val->entry_form==2)
                {
                    $data['sales_offer_list']['sales_offer_acceptance_date']  =date("D M d, Y",strtotime($val->created_at));
                    $data['sales_offer_list']['sales_offer_acceptance_no']    =$val->transaction_no;
                }
                else if($val->entry_form==3)
                {
                     $data['sales_offer_list']['sales_order_no']              =date("D M d, Y",strtotime($val->created_at));
                     $data['sales_offer_list']['sales_order_date']            =$val->transaction_no;
                }
                else if($val->entry_form==4)
                {
                    $data['sales_offer_list']['packing_slip_date']               =date("D M d, Y",strtotime($val->created_at));
                    $data['sales_offer_list']['packing_slip_no']                 =$val->transaction_no;
                }
                else if($val->entry_form==5)
                {
                    $data['sales_offer_list']['sales_return_date']             =date("D M d, Y",strtotime($val->created_at));
                    $data['sales_offer_list']['sales_return_no']               =$val->transaction_no;
                }
                else if($val->entry_form==6)
                {
                    $data['sales_offer_list']['sales_debit_note_date']        =date("D M d, Y",strtotime($val->created_at));
                    $data['sales_offer_list']['sales_debit_note_no']          =$val->transaction_no;
                }
                else if($val->entry_form==7)
                {
                    $data['sales_offer_list']['sales_credit_note_date']        =date("D M d, Y",strtotime($val->created_at));
                    $data['sales_offer_list']['sales_credit_note_no']          =$val->transaction_no;
                }
                else if($val->entry_form==8)
                {
                    $data['sales_offer_list']['sales_invoice_date']             =date("D M d, Y",strtotime($val->created_at));
                    $data['sales_offer_list']['sales_invoice_no']               =$val->transaction_no;
                }
                

            }

            $data['sales_offer_list']['notification_by']                 =$value->notification_by;            
            $data['sales_offer_list']['backorder_allowed']               =$value->backorder_allowed;

            $data['sales_offer_list']['vehicle_identification_number']   =$value->vehicle_identification_number;
            $data['sales_offer_list']['vehicle_make']                    =$value->vehicle_make;
            $data['sales_offer_list']['vehicle_model']                   =$value->vehicle_model;
            $data['sales_offer_list']['vehicle_year']                    =$value->vehicle_year;
            $data['sales_offer_list']['vehicle_type']                    =$value->vehicle_type;            
            $data['sales_offer_list']['vehicle_license_plate']           =$value->vehicle_license_plate;

            $data['sales_offer_list']['vehicle_image']                   =$value->vehicle_image;
            $data['sales_offer_list']['vehicle_make']                    =$value->vehicle_make;
            $data['sales_offer_list']['vehicle_model']                   =$value->vehicle_model;
            $data['sales_offer_list']['vehicle_year']                    =$value->vehicle_year;
            $data['sales_offer_list']['vehicle_type']                    =$value->vehicle_type;            
            $data['sales_offer_list']['vehicle_license_plate']           =$value->vehicle_license_plate;

            $data['sales_offer_list']['vehicle_identification_number']   =$value->vehicle_identification_number;
            $data['sales_offer_list']['vehicle_image_id']                =$value->vehicle_image_id;
            $data['sales_offer_list']['vehicle_insurance_information']   =$value->vehicle_insurance_information;
            

            if($value->seller_id>0)
            {
                $data['sales_offer_list']['seller_name']         =$account_holder_list[$value->seller_id]->register_corp_first_name." ".$account_holder_list[$value->seller_id]->register_corp_middle_name." ".$account_holder_list[$value->seller_id]->register_corp_last_name;
                $data['sales_offer_list']['seller_id']           =$account_holder_list[$value->seller_id]->id;
                $data['sales_offer_list']['seller_account_no']   =$account_holder_list[$value->seller_id]->system_no;
                $data['sales_offer_list']['seller_photo']        =$account_holder_list[$value->seller_id]->id;
                $data['sales_offer_list']['seller_photo_id']     ="";
                $data['sales_offer_list']['seller_contact_no']   =$account_holder_list[$value->seller_id]->cell_phone;
                $data['sales_offer_list']['seller_address']      ="H-".$account_holder_list[$value->seller_id]->house_number.", R-".$account_holder_list[$value->seller_id]->street_number.", City-".$account_holder_list[$value->seller_id]->city.", State-".$account_holder_list[$value->seller_id]->state.", Zip-Code-".$account_holder_list[$value->seller_id]->zip_code.", Country-".$country_arr[$account_holder_list[$value->seller_id]->country];
            }
            else
            {
                $data['sales_offer_list']['seller_name']         ="";
                $data['sales_offer_list']['seller_account_no']   ="";
                $data['sales_offer_list']['seller_photo']        ="";
                $data['sales_offer_list']['seller_photo_id']     ="";
                $data['sales_offer_list']['seller_contact_no']   ="";
                $data['sales_offer_list']['seller_address']      ="";

            }

            if($value->service_provider_id>0)
            {
                $data['sales_offer_list']['service_provider_name']         =$account_holder_list[$value->service_provider_id]->register_corp_first_name." ".$account_holder_list[$value->service_provider_id]->register_corp_middle_name." ".$account_holder_list[$value->service_provider_id]->register_corp_last_name;
                $data['sales_offer_list']['service_provider_id']           =$account_holder_list[$value->service_provider_id]->id;
                $data['sales_offer_list']['service_provider_account_no']   =$account_holder_list[$value->service_provider_id]->system_no;
                $data['sales_offer_list']['service_provider_photo']        =$account_holder_list[$value->service_provider_id]->id;
                $data['sales_offer_list']['service_provider_photo_id']     ="";
                $data['sales_offer_list']['service_provider_contact_no']   =$account_holder_list[$value->service_provider_id]->cell_phone;
                $data['sales_offer_list']['service_provider_address']      ="H-".$account_holder_list[$value->service_provider_id]->house_number.", R-".$account_holder_list[$value->service_provider_id]->street_number.", City-".$account_holder_list[$value->service_provider_id]->city.", State-".$account_holder_list[$value->service_provider_id]->state.", Zip-Code-".$account_holder_list[$value->service_provider_id]->zip_code.", Country-".$country_arr[$account_holder_list[$value->service_provider_id]->country];
            }
            else
            {
                $data['sales_offer_list']['service_provider_name']         ="";
                $data['sales_offer_list']['service_provider_account_no']   ="";
                $data['sales_offer_list']['service_provider_photo']        ="";
                $data['sales_offer_list']['service_provider_photo_id']     ="";
                $data['sales_offer_list']['service_provider_contact_no']   ="";
                $data['sales_offer_list']['service_provider_address']      ="";

            }

            if($value->customer_id>0)
            {
                $data['sales_offer_list']['customer_name']         =$account_holder_list[$value->customer_id]->register_corp_first_name." ".$account_holder_list[$value->customer_id]->register_corp_middle_name." ".$account_holder_list[$value->customer_id]->register_corp_last_name;
                $data['sales_offer_list']['customer_id']           =$account_holder_list[$value->customer_id]->id;
                $data['sales_offer_list']['customer_account_no']   =$account_holder_list[$value->customer_id]->system_no;
                $data['sales_offer_list']['customer_photo']        =$account_holder_list[$value->customer_id]->id;
                $data['sales_offer_list']['customer_photo_id']     ="";
                $data['sales_offer_list']['customer_contact_no']   =$account_holder_list[$value->customer_id]->cell_phone;
                $data['sales_offer_list']['customer_address']      ="H-".$account_holder_list[$value->customer_id]->house_number.", R-".$account_holder_list[$value->customer_id]->street_number.", City-".$account_holder_list[$value->customer_id]->city.", State-".$account_holder_list[$value->customer_id]->state.", Zip-Code-".$account_holder_list[$value->customer_id]->zip_code.", Country-".$country_arr[$account_holder_list[$value->customer_id]->country];
            }
            else
            {
                $data['sales_offer_list']['customer_name']         ="";
                $data['sales_offer_list']['customer_account_no']   ="";
                $data['sales_offer_list']['customer_photo']        ="";
                $data['sales_offer_list']['customer_photo_id']     ="";
                $data['sales_offer_list']['customer_contact_no']   ="";
                $data['sales_offer_list']['customer_address']      ="";

            }

            if($value->shipping_company_id>0)
            {
                $data['sales_offer_list']['shipping_company_name']         =$account_holder_list[$value->shipping_company_id]->register_corp_first_name." ".$account_holder_list[$value->shipping_company_id]->register_corp_middle_name." ".$account_holder_list[$value->shipping_company_id]->register_corp_last_name;
                $data['sales_offer_list']['shipping_company_id']           =$account_holder_list[$value->shipping_company_id]->id;
                $data['sales_offer_list']['shipping_company_account_no']   =$account_holder_list[$value->shipping_company_id]->system_no;
                $data['sales_offer_list']['shipping_company_photo']        =$account_holder_list[$value->shipping_company_id]->id;
                $data['sales_offer_list']['shipping_company_photo_id']     ="";
                $data['sales_offer_list']['shipping_company_contact_no']   =$account_holder_list[$value->shipping_company_id]->cell_phone;
                $data['sales_offer_list']['shipping_company_address']      ="H-".$account_holder_list[$value->shipping_company_id]->house_number.", R-".$account_holder_list[$value->shipping_company_id]->street_number.", City-".$account_holder_list[$value->shipping_company_id]->city.", State-".$account_holder_list[$value->shipping_company_id]->state.", Zip-Code-".$account_holder_list[$value->shipping_company_id]->zip_code.", Country-".$country_arr[$account_holder_list[$value->shipping_company_id]->country];
            }
            else
            {
                $data['sales_offer_list']['shipping_company_name']         ="";
                $data['sales_offer_list']['shipping_company_account_no']   ="";
                $data['sales_offer_list']['shipping_company_photo']        ="";
                $data['sales_offer_list']['shipping_company_photo_id']     ="";
                $data['sales_offer_list']['shipping_company_contact_no']   ="";
                $data['sales_offer_list']['shipping_company_address']      ="";
            }

            if($value->driver_id>0)
            {
                $data['sales_offer_list']['driver_name']         =$account_holder_list[$value->driver_id]->register_corp_first_name." ".$account_holder_list[$value->driver_id]->register_corp_middle_name." ".$account_holder_list[$value->driver_id]->register_corp_last_name;
                $data['sales_offer_list']['driver_id']           =$account_holder_list[$value->driver_id]->id;
                $data['sales_offer_list']['driver_account_no']   =$account_holder_list[$value->driver_id]->system_no;
                $data['sales_offer_list']['driver_license_no']   =$account_holder_list[$value->driver_id]->system_no;
                $data['sales_offer_list']['driver_photo']        =$account_holder_list[$value->driver_id]->id;
                $data['sales_offer_list']['driver_photo_id']     ="";
                $data['sales_offer_list']['driver_contact_no']   =$account_holder_list[$value->driver_id]->cell_phone;
                $data['sales_offer_list']['driver_address']      ="H-".$account_holder_list[$value->driver_id]->house_number.", R-".$account_holder_list[$value->driver_id]->street_number.", City-".$account_holder_list[$value->driver_id]->city.", State-".$account_holder_list[$value->driver_id]->state.", Zip-Code-".$account_holder_list[$value->driver_id]->zip_code.", Country-".$country_arr[$account_holder_list[$value->driver_id]->country];
            }
            else
            {
                $data['sales_offer_list']['driver_name']         ="";
                $data['sales_offer_list']['driver_account_no']   ="";
                $data['sales_offer_list']['driver_photo']        ="";
                $data['sales_offer_list']['driver_photo_id']     ="";
                $data['sales_offer_list']['driver_contact_no']   ="";
                $data['sales_offer_list']['driver_address']      ="";
                $data['sales_offer_list']['driver_license_no']   ="";

            }

            
            $sl++;

        }

        $sales_charge_details_breakdown=SaleChargeBreakdown::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('master_id',$id)
                                        ->get();
        $charge_details_breakdown_arr=array();                               
        foreach($sales_charge_details_breakdown as $val)
        {
            $charge_details_breakdown_arr[$val->detail_id][$val->charge_type][$val->charge_id]['id']=$val->id;
            $charge_details_breakdown_arr[$val->detail_id][$val->charge_type][$val->charge_id]['charge_type']=$val->charge_type;
            $charge_details_breakdown_arr[$val->detail_id][$val->charge_type][$val->charge_id]['amount']=$val->amount;
            $charge_details_breakdown_arr[$val->detail_id][$val->charge_type][$val->charge_id]['reference_id']=$val->charge_id;

        }

        //dd($charge_details_breakdown_arr);die;
        $sales_details=SaleDetails::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('master_id',$id)
                                        ->get();

        $charge_details_arr=array(); 
        $sl=0;  $total_addition=0; $total_deduction=0;   $total_sub_total=0; $total_tax=0; $grand_total=0;                        
        foreach($sales_details as $val)
        {
            $charge_details_arr[$sl]['item_name']  =$val->item_name;
            $charge_details_arr[$sl]['id']         =$val->id;
            $charge_details_arr[$sl]['product_id']=$val->product_id;
            $charge_details_arr[$sl]['item_description']=$val->item_description;
            $charge_details_arr[$sl]['qty']=$val->qty;
            $charge_details_arr[$sl]['rate']=$val->rate;
            $charge_details_arr[$sl]['addition']=$val->addition;
            $charge_details_arr[$sl]['deduction']=$val->deduction;
            $charge_details_arr[$sl]['addition_percent']=$val->addition_percent;
            $charge_details_arr[$sl]['deduction_percent']=$val->deduction_percent;
            $charge_details_arr[$sl]['sub_total']=$val->sub_total;
            $charge_details_arr[$sl]['tax_rate']=$val->tax_rate;
            $charge_details_arr[$sl]['tax']=$val->tax;
            $charge_details_arr[$sl]['total']=$val->total;
            $total_addition     +=$val->addition;
            $total_deduction    +=$val->deduction;
            $total_sub_total    +=$val->sub_total;
            $total_tax          +=$val->tax;
            $grand_total        +=$val->total;

            if(!empty($charge_details_breakdown_arr[$val->id]))
            {

                foreach($charge_details_breakdown_arr[$val->id] as $index=>$charge_value)
                {
                    $brsl=0;
                    foreach($charge_value as $value)
                    {
                       
                        if($index==1)
                        {
                            $charge_details_arr[$sl]['addition_distribution'][$brsl]['reference_id']=$value['reference_id'];
                            $charge_details_arr[$sl]['addition_distribution'][$brsl]['id']=$value['id'];
                            $charge_details_arr[$sl]['addition_distribution'][$brsl]['charge_type']=$value['charge_type'];
                            $charge_details_arr[$sl]['addition_distribution'][$brsl]['reference_value']=$value['amount'];
                        }
                        else
                        {
                            $charge_details_arr[$sl]['deduction_distribution'][$brsl]['reference_id']=$value['reference_id'];
                            $charge_details_arr[$sl]['deduction_distribution'][$brsl]['id']=$value['id'];
                            $charge_details_arr[$sl]['deduction_distribution'][$brsl]['charge_type']=$value['charge_type'];
                            $charge_details_arr[$sl]['deduction_distribution'][$brsl]['reference_value']=$value['amount'];

                        }
                        $brsl++;
                    }
                }
            }

           
            $sl++;
        }

        $sales_charge_details=SaleCharge::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('master_id',$id)
                                        ->get();

        $sales_charge_details_arr=array();
        $csl=0;
        foreach ($sales_charge_details as $key => $row) 
        {
            $sales_charge_details_arr[$csl]['id']            =$row->id;
            $sales_charge_details_arr[$csl]['charge_id']     =$row->charge_id;

            if($row->charge_type==1)
                $sales_charge_details_arr[$csl]['charge_name']   =$additional_charge_arr[$row->charge_id];
            else
                 $sales_charge_details_arr[$csl]['charge_name']   =$deduction_charge_arr[$row->charge_id];
            $sales_charge_details_arr[$csl]['charge_type']   =$row->charge_type;
            $sales_charge_details_arr[$csl]['amount']        =$row->amount;
            $csl++;
        }
        $data['total_addition']                 =$total_addition;
        $data['total_deduction']                =$total_deduction;
        $data['sub_total']                      =$total_sub_total;
        $data['total_tax']                      =$total_tax;
        $data['grand_total']                    =$grand_total;
        // $data['charge_details_arr']             =$charge_details_arr;
        // $data['charge_details_arr']             =$charge_details_arr;
        // $data['charge_details_arr']             =$charge_details_arr;
        // $data['charge_details_arr']             =$charge_details_arr;
        // $data['charge_details_arr']             =$charge_details_arr;

        $data['charge_details_arr']             =$charge_details_arr;
        $data['sales_charge_details_arr']    =$sales_charge_details_arr;
        
        return $data;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'form_date'                     => 'required',
            'form_type'                     => 'required',
            'priority_level'                => 'required',
            'subject'                       => 'required',
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
   
        $form_date                    =date("Y-m-d",strtotime($request->input('form_date')));
        $request->merge(['form_date'         =>$form_date]);
        $request->merge(['user_id' =>$user_id]);
        //$request->merge(['posting_status' =>3]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);


        $company_id="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return; 
        }

        $request->merge(['company_id' =>$company_id]);

        DB::beginTransaction();
        $sales_offer_info= FormEntry::find($id)->update($request->all());


        if($sales_offer_info)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        } 
    }



    public function adjust(Request $request, $id)
    {
        request()->validate([
            'form_date'                     => 'required',
            'form_type'                     => 'required',
            'priority_level'                => 'required',
            'subject'                       => 'required',
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
   
        $form_date                    =date("Y-m-d",strtotime($request->input('form_date')));
        $request->merge(['form_date'         =>$form_date]);
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['posting_status' =>3]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);


        $company_id="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return; 
        }

        $request->merge(['company_id' =>$company_id]);

        DB::beginTransaction();
        $sales_offer_info= FormEntry::find($id)->update($request->all());


        if($sales_offer_info)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        $RID1=true;
        $RID2=true;


        $update_data= array(
                        
                            'status_active'             =>0,
                            'is_deleted'                =>1,
                            'updated_by'                =>$user_id,
                        );
        $sales_delete=FormEntry::where('id',"=",$id)->update($update_data);
       

        if($sales_delete)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }

    public function post(Request $request,$id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 


        $update_data= array(
                            'posting_status'             =>2,
                            'updated_by'                =>$user_id,
                        );

        $sales=Sale::where('id',"=",$id)->update($update_data);
       

        if($sales)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }

    public function repost($id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        $RID1=true;
        $RID2=true;

        $update_data= array(
                            'posting_status'            =>4,
                            'updated_by'                =>$user_id,
                        );

        $sales=FormEntry::where('id',"=",$id)->update($update_data);
       

        if($sales)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }
}
