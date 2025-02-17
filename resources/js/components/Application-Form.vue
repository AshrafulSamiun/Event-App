<template>

	<section class="app-main__inner">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card">
                <form id="msform" @submit.prevent="editmode ? updateApplicationForm() : createApplicationForm()" @keydown="form.onKeydown($event)">  
                    <fieldset>
                        <div id="content">
                            <div class="form-card">
                                <h1 class="page-head">Application Form</h1> 
                                <div class="form-folder">
                                    <h3><i class="fa fa-hand-point-right"></i>Application Form:</h3> 
                                    <div class="form-holder">
                                        <div class="row align-self-stretch"> 
                                            <div class="col-md-3 col-sm-6 col-xs-12"> 
                                                <div class="form-box-outer">
                                                    <h4>Applicant Details</h4>
                                                    <label class="fieldlabels">Application No:</label> 
                                                    <input type="text" 
                                                        id="system_no" 
                                                        name="system_no" 
                                                        v-model="form.system_no"  
                                                        placeholder="Application No" disabled/>

                                                    <label class="fieldlabels" >BA  No:</label>  
                                                    <input v-model="form.ba_number" 
                                                        type="text" 
                                                        placeholder="Type BA No"
                                                        name="ba_number" 
                                                        :class="{ 'is-invalid': form.errors.has('ba_number') }"/>
                                                      <has-error :form="form" field="ba_number"></has-error>
                                                    
                                                    <label class="fieldlabels" > Name:</label>  
                                                    <input v-model="form.full_name" 
    													type="text" 
    													placeholder="Type Name"
    													name="full_name" 
    													:class="{ 'is-invalid': form.errors.has('full_name') }"/>
    											      <has-error :form="form" field="full_name"></has-error>
    													  <input v-model="form.id" type="hidden" name="id">
                                                   

                                                   <label class="fieldlabels" > Rank:</label>  
                                                    

                                                    <div class="position-relative form-group">
                                                        <select v-model="form.rank"
                                                            name="rank"
                                                            class="custom-select" 
                                                            :class="{ 'is-invalid': form.errors.has('rank') }">
                                                            <option disabled value="">--Select-- </option>
                                                            <option value="1">Domestic</option>
                                                            <option value="2">International</option>
                                                            <option value="3">Both</option>
                                                        </select>
                                                        <has-error :form="form" field="rank"></has-error> 
                                                    </div>

                                                    <label class="fieldlabels" > Unit/Formation/Institute:</label>  
                                                    <input v-model="form.unit" 
                                                        type="text" 
                                                        placeholder="Type Unit/Formation/Institute"
                                                        name="unit" 
                                                        :class="{ 'is-invalid': form.errors.has('unit') }"/>
                                                      <has-error :form="form" field="unit"></has-error>

                                                    <label class="fieldlabels" > Mobile No:</label>  
                                                    <input v-model="form.mobile_no" 
                                                        type="text" 
                                                        placeholder="Type Mobile No"
                                                        name="mobile_no" 
                                                        :class="{ 'is-invalid': form.errors.has('mobile_no') }"/>
                                                      <has-error :form="form" field="mobile_no"></has-error>

                                                    <label class="fieldlabels" > Service Length:</label>  
                                                    <input v-model="form.service_length" 
                                                        type="text" 
                                                        placeholder="Type Service Length"
                                                        name="service_length" 
                                                        :class="{ 'is-invalid': form.errors.has('service_length') }"/>
                                                      <has-error :form="form" field="service_length"></has-error>
                                                    
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <div class="form-box-outer">
                                                    <h4>Land Details</h4>
                                                    
                                                            <label class="fieldlabels">Plot:</label> 
                                                             <input 
                                                                v-model="form.plot" 
                                                                type="text" 
                                                                name="plot" 
                                                                placeholder="Type Plot" 
                                                                :class="{ 'is-invalid': form.errors.has('plot') }"/>
                                                            <has-error :form="form" field="plot"></has-error> 

                                                            <label class="fieldlabels">Road:</label> 
                                                             <input 
                                                                v-model="form.road" 
                                                                type="text" 
                                                                name="road" 
                                                                placeholder="Type Road" 
                                                                :class="{ 'is-invalid': form.errors.has('road') }"/>
                                                            <has-error :form="form" field="road"></has-error>
                                                            

                                                            <label class="fieldlabels">Sector:</label> 
                                                            <div class="position-relative form-group">
                                                                <select v-model="form.sector"
                                                                    name="sector"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('sector') }">
                                                                    <option disabled value="">--Select-- </option>
                                                                    <option v-for="sec in 25" :value="sec" v-if="sec>0"> Sector {{sec}} </option>
                                                                </select>
                                                                <has-error :form="form" field="sector"></has-error> 
                                                            </div>

                                                            <label class="fieldlabels">Soil Test:</label> 
                                                            <div class="form-check-inline">
                                                                <input 
                                                                    type="checkbox" 
                                                                    @change="check_soil_test($event,1)" 
                                                                    name="soil_test_yes" 
                                                                    id="soil_test_yes"
                                                                    v-model="form.soil_test_yes" >
                                                                <label for="soil_test_yes">Yes</label>

                                                                <input type="checkbox"
                                                                    @change="check_soil_test($event,2)"  
                                                                    name="soil_test_no" 
                                                                    id="soil_test_no"
                                                                    v-model="form.soil_test_no">
                                                                <label for="soil_test_no">No</label><br>
                                                            </div>

                                                            <label class="fieldlabels"> Date of Soil Test:</label> 
                                                            <date-picker 
                                                                
                                                                v-model="form.soil_test_date"
                                                                name="soil_test_date"
                                                                lang="en"
                                                                type="text" 
                                                                style="width:100%"
                                                                placeholder="Enter Date" 
                                                                format="DD MMM, YYYY"
                                                                :class="{ 'is-invalid': form.errors.has('soil_test_date') }">
                                                            </date-picker>
                                                          <has-error :form="form" field="soil_test_date"></has-error>   
                                                          <label class="fieldlabels">Structural Design:</label> 
                                                            <div class="form-check-inline">
                                                                <input 
                                                                    type="checkbox" 
                                                                    @change="check_structural_design($event,1)" 
                                                                    name="structural_design_yes" 
                                                                    id="structural_design_yes"
                                                                    v-model="form.structural_design_yes" >
                                                                <label for="structural_design_yes">Yes</label>

                                                                <input type="checkbox"
                                                                    @change="check_structural_design($event,2)"  
                                                                    name="structural_design_no" 
                                                                    id="structural_design_no"
                                                                    v-model="form.structural_design_no">
                                                                <label for="structural_design_no">No</label><br>
                                                            </div>
                                                    
                                                    
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <div class="form-box-outer">
                                                    <h4>Piling Details</h4>
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Required Number of Piles:</label> 
                                                            <input v-model="form.required_number_of_piles" 
                                                               type="text" 
                                                               name="required_number_of_piles" 
                                                               placeholder="Type Required Number of Piles"
                                                               :class="{ 'is-invalid': form.errors.has('required_number_of_piles') }"/>
                                                            <has-error :form="form" field="required_number_of_piles"></has-error>
                                                            
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Depth of Each Pile:</label> 
                                                            <input v-model="form.depth_of_each_piles" 
                                                               type="text" 
                                                               name="depth_of_each_piles" 
                                                               placeholder="Type Depth of Each Pile"
                                                               :class="{ 'is-invalid': form.errors.has('depth_of_each_piles') }"/>
                                                            <has-error :form="form" field="depth_of_each_piles"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Expected Date of Piling:</label> 
                                                            <date-picker 
                                                                v-model="form.ex_piling_date"
                                                                name="ex_piling_date"                                  lang="en" 
                                                                placeholder="Enter Date" 
                                                                format="DD MMM, YYYY"
                                                                 style="width:100%"
                                                                :class="{ 'is-invalid': form.errors.has('ex_piling_date') }">
                                                            </date-picker>
                                                            <has-error :form="form" field="ex_piling_date"></has-error>
                                                        </div>
                                                        
                                                    </div>
                                                        
                                                    
                                                    <h4>Business</h4>
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">TIN No:</label> 
                                                            <input v-model="form.tin_no" 
                                                               type="text" 
                                                               name="tin_no" 
                                                               placeholder="Type TIN No"
                                                               :class="{ 'is-invalid': form.errors.has('tin_no') }"/>
                                                            <has-error :form="form" field="tin_no"></has-error> 

                                                            <label class="fieldlabels">National ID No:</label> 
                                                            <input v-model="form.national_id_no" 
                                                               type="text" 
                                                               name="national_id_no" 
                                                               placeholder="Type National ID No"
                                                               :class="{ 'is-invalid': form.errors.has('national_id_no') }"/>
                                                            <has-error :form="form" field="national_id_no"></has-error> 

                                                            <label class="fieldlabels">Bank Account No:</label> 
                                                            <input v-model="form.bank_account_no" 
                                                               type="text" 
                                                               name="bank_account_no" 
                                                               placeholder="Type Bank Account No"
                                                               :class="{ 'is-invalid': form.errors.has('bank_account_no') }"/>
                                                            <has-error :form="form" field="bank_account_no"></has-error> 
                                                        </div>
                                                        
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <div class="form-box-outer">
                                                    <h4>Address</h4>
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Current Address:</label> 
                                                            <textarea
                                                                v-model="form.current_address"
                                                                id="current_address" 
                                                                name="current_address" 
                                                                rows="7" 
                                                                cols="150"
                                                                style="height:120px"
                                                                placeholder="Type Current Address"
                                                                :class="{ 'is-invalid': form.errors.has('current_address') }">
                                                            </textarea>
                                                            
                                                            <has-error :form="form" field="current_address"></has-error>
                                                            <label class="fieldlabels">Permanent Address:</label> 
                                                            <textarea
                                                                v-model="form.permanent_address"
                                                                id="permanent_address" 
                                                                name="permanent_address" 
                                                                rows="7" 
                                                                cols="150"
                                                                style="height:120px"
                                                                placeholder="Type Permanent Address"
                                                                :class="{ 'is-invalid': form.errors.has('permanent_address') }">
                                                            </textarea>
                                                            
                                                            <has-error :form="form" field="permanent_address"></has-error>

                                                            <label class="fieldlabels">NOK Name:</label> 
                                                            <textarea
                                                                v-model="form.nok_name"
                                                                id="nok_name" 
                                                                name="nok_name" 
                                                                rows="7" 
                                                                cols="150"
                                                                style="height:120px"
                                                                placeholder="Type Name, Mobile No and Relation"
                                                                :class="{ 'is-invalid': form.errors.has('nok_name') }">
                                                            </textarea>
                                                            
                                                            <has-error :form="form" field="nok_name"></has-error>
                                                        </div>
                                                        
                                                    </div>
                                                     
                                                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            
                        </div>
                        <div class="text-center">
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                            <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Edit</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click.prevent="deleteCompany()">Delete</button>
                            <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" >Save</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button>
                        </div>
                    </fieldset> 
					
                   

                </form>
            </div>
        </div>

     
    </div>

   


</section>


</template>

<script>
	import {ref} from "vue";
	import VueTimepicker from 'vue2-timepicker';
    import 'vue2-timepicker/dist/VueTimepicker.css';
    //import { jsPDF } from "jspdf";
	
    import jsPDF  from "jspdf";

    export default {
        name:'list-product-categories',
        components:{
            VueTimepicker 
        },
        data(){
            return{
            	editmode:false,
				filter: '',
            	form:new Form({
            		
                    system_no:'',
                    ba_number:'',
                    id:'',
                    full_name:'',
                    rank:'',
                    unit:'',
                    mobile_no:'',
                    service_length:'',
                    plot:'',
                    road:'',
                    sector:'',
                    soil_test_date:'',
                    required_number_of_piles:'',
                    depth_of_each_piles:'',
                    ex_piling_date:'',
                    tin_no:'',
                    national_id_no:'',
                    bank_account_no:'',
                    current_address:'',

                    permanent_address:'',
                    nok_name:'',
                    
                    soil_test_yes:false,
                    soil_test_no:false,
                    soil_test:false,

                    structural_design_yes:false,
                    structural_design_no:false,
                    structural_design:false,             	
                  	
            	}),
            	
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchApplicationForm();
           //this.fetchApplicationFormUpdate(1);

           
        },
		
	    methods: {
            show_pdf()
            {

                  const doc = new jsPDF();
               // const html=this.$refs.content.innerHTML;
                const html=document.getElementById('content').innerHTML;
                doc.text(html, 10, 10);
               // doc.fromHTML(html, 10, 10,{ width:250});
                doc.save("a4.pdf"); return;
                //https://www.npmjs.com/package/jspdf

                 var pdf = new jsPDF();
                var element = document.getElementById('content');
                var width= element.style.width;
                var height = element.style.height;
                html2canvas(element).then(canvas => {
                    var image = canvas.toDataURL('image/png');
                    pdf.addImage(image, 'JPEG', 15, 40, width, height);
                    pdf.save('facture' + moment(this.facture.date_debut).format('LL') + '_' + moment(this.facture.date_fin).format('LL') + '.pdf');
                });

                return;
              
            },
            reset_form()
            {

                this.form.reset ();
                this.editmode=false;
                
            },

           
            check_soil_test(e,type){
                if(e.target.checked)
                {
                    if(type==1)
                    {
                        this.form.soil_test_yes=true;
                        this.form.soil_test_no=false;
                        this.form.soil_test=true;
                        
                    }
                    else if(type==2)
                    {
                        this.form.soil_test_yes=false;
                        this.form.soil_test_no=true;
                        this.form.soil_test=false;
                    }
                }
                else{
                    this.form.soil_test_yes=false;
                    this.form.soil_test_no=false;
                    this.form.soil_test=false;
                }               
            },
            
            check_structural_design(e,type){
                if(e.target.checked)
                {
                    if(type==1)
                    {
                        this.form.structural_design_yes=true;
                        this.form.structural_design_no=false;
                        this.form.structural_design=true;
                        
                    }
                    else if(type==2)
                    {
                        this.form.structural_design_yes=false;
                        this.form.structural_design_no=true;
                        this.form.structural_design=false;
                    }
                }
                else{
                    this.form.structural_design_yes=false;
                    this.form.structural_design_no=false;
                    this.form.structural_design=false;
                }               
            },

            

            


            fetchApplicationForm()
            {
                let uri = '/ApplicationForms';
                window.axios.get(uri).then((response) => {
                    
                    this.main_company_arr                       =response.data.main_company_arr;
                    this.countries                              =response.data.country_arr;
                    this.account_status_arr                     =response.data.account_status_arr;
                    this.payment_term_arr                       =response.data.payment_term_arr;
                    this.currency_arr                           =response.data.currency_arr;
                    this.key_position_lavel                     =response.data.key_position_lavel_arr;
                    this.government_account_lavel               =response.data.government_account_lavel_arr;

                    this.editmode=false;
                    for(let i=0; i<this.government_account_lavel.length; i++){

                        this.form.government_account_lavel_data.push({
                            'id':'',
                            'reference_id':this.government_account_lavel[i].id,
                            'reference_value':this.government_account_lavel[i].field_name,
                            'account_number':'',
                            'filling_date':'',
                            'filling_cycle':'',
                            'is_callender':0,
                        
                        });
                    }

                    for(let i=0; i<this.key_position_lavel.length; i++){

                        this.form.key_position_lavel_data.push({
                            'id':'',
                            'reference_id':this.key_position_lavel[i].id,
                            'reference_value':this.key_position_lavel[i].field_name,
                            'office_phone':'',
                            'office_mobile':'',
                            'fax':'',
                            'key_position_name':'',
                            'email':'',
                        
                        });
                    }

                    
                }); 

                
            },
         
       

            updateApplicationForm()
            {
            
				
		        this.form.put('/ApplicationForms/'+this.form.id)
				    .then(({ data })=>{
                        var response_data=data.split("**");
						if(response_data[0]==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Update Successfully'
                            });

                            this.fetchApplicationFormUpdate(response_data[1]);
                            this.editmode=true;

                        }
                        else{

                            toast({
                                type: 'danger',
                                title: 'Invalid Operation'
                            });
                        }
				    })
				    .catch(()=>{
					   showAlert("failed!","there was some wrong","warning");
				
				    });
            },
            
            createApplicationForm()
            {

        	    this.form.post('/ApplicationForms') .then(({ data }) => { 
               
					var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
    					toast({
    						type: 'success',
    						title: 'Data Save Successfully'
    					});

    					this.form.reset ();
    					this.fetchApplicationFormUpdate(response_data[1]);
                    }
                    else{

                        showToast("there was some wrong","warning");
                    }
        	    })
            },


            fetchApplicationFormUpdate(id){
                this.form.reset ();

                let uri = '/ApplicationForms/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    

                    this.form.id                        =response.data.application_data[0].id;
                    this.form.system_no                 =response.data.application_data[0].system_no;
                    this.form.ba_number                 =response.data.application_data[0].ba_number;
                    this.form.full_name                 =response.data.application_data[0].full_name;
                    this.form.rank                      =response.data.application_data[0].rank;
                    this.form.unit                      =response.data.application_data[0].unit;
                    this.form.mobile_no                 =response.data.application_data[0].mobile_no;
                    this.form.service_length            =response.data.application_data[0].service_length;
                    this.form.plot                      =response.data.application_data[0].plot;
                    this.form.road                      =response.data.application_data[0].road;
                    this.form.sector                    =response.data.application_data[0].sector;
                    this.form.soil_test_date            =response.data.application_data[0].soil_test_date;
                    this.form.required_number_of_piles  =response.data.application_data[0].required_number_of_piles;

                    this.form.depth_of_each_piles       =response.data.application_data[0].depth_of_each_piles;
                    this.form.ex_piling_date            =response.data.application_data[0].ex_piling_date;
                    this.form.tin_no                    =response.data.application_data[0].tin_no;
                    this.form.national_id_no            =response.data.application_data[0].national_id_no;
                    this.form.bank_account_no           =response.data.application_data[0].bank_account_no;
                    this.form.current_address           =response.data.application_data[0].current_address;
                    this.form.permanent_address         =response.data.application_data[0].permanent_address;
                    this.form.nok_name                  =response.data.application_data[0].nok_name;
                   
                   if(response.data.application_data[0].soil_test==1){
                        this.form.soil_test_yes=true;
                        this.form.soil_test_no=false;
                    }
                    else if(response.data.application_data[0].soil_test==2){
                        this.form.soil_test_yes=false;
                        this.form.soil_test_no=true;
                    }
                    else{
                        this.form.soil_test_yes=false;
                        this.form.soil_test_no=false;
                    }


                    if(response.data.application_data[0].structural_design==1){
                        this.form.structural_design_yes=true;
                        this.form.structural_design_no=false;
                    }
                    else if(response.data.application_data[0].structural_design==2){
                        this.form.structural_design_yes=false;
                        this.form.structural_design_no=true;
                    }
                    else{
                        this.form.structural_design_yes=false;
                        this.form.structural_design_no=false;
                    }
                    
                    this.editmode=true;
    

                    
                }); 

            },


            deleteCompany()
            {            

                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {

                      this.form.delete('/ApplicationForms/'+this.form.id).then(()=>{
                        
                          if(result.value) {
                               showAlert(
                                'Deleted!',
                                'Your Company has been deleted.',
                                'success'
                              );
                             this.form.reset();
                             this.fetchApplicationForm();
                          }            

                      }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
                  });
               
              })
            },
            


	    }
    
    }  
	
</script>



