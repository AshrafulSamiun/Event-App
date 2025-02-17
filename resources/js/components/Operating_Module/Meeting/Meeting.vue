<template>
    <fieldset>
           <h4 class="breadcumb"> Meeting</h4>
           <p class="breadcumb-p">Operation Modules/Administrative/Meeting</p>
           
           <div class="text-center" style=" margin-top:20px">
               <button 
                   v-show="data_entry" 
                   type="button" 
                   class=" btn-action-bar"  
                   @click="reset_form()">Create New</button>
               <button 
                   type="button" 
                   class=" btn-action-bar" 
                   :class="{ 'btn-action-bar-dissable': !data_entry, 'btn-action-bar': data_entry}"
                   @click="data_enty_show()">Data Entry </button>
             
               <button 
                   v-show="!editmode"
                   type="button" 
                   class=" btn-action-bar" 
                   :class="{ 'btn-action-bar-dissable': !save_btn, 'btn-action-bar': save_btn}"
                   @click="save_show()">Save
               </button>
               <button 
                   v-show="editmode"
                   type="button" 
                   class=" btn-action-bar" 
                   :class="{ 'btn-action-bar-dissable': !print_btn, 'btn-action-bar': print_btn}" 
                   @click.prevent="btn_print()">Print
               </button>
               <button 
                   type="button" 
                   class=" btn-action-bar" 
                   :class="{ 'btn-action-bar-dissable': !approval_btn, 'btn-action-bar': approval_btn}"
                   @click="approval_show()" >Approval
               </button>



               <button 
                   :class="{ 'btn-action-bar-dissable': !posting_status_btn, 'btn-action-bar': posting_status_btn}"  
                   type="button" 
                   class=" btn-action-bar" 
                   @click="posting_status_show()" >Posting Status
               </button>

               <button 
                  :class="{ 'btn-action-bar-dissable': !list_btn, 'btn-action-bar': list_btn}"   
                   type="button" 
                   class=" btn-action-bar" 
                   @click="reset_list()">List</button>
               
           </div>


           <div class="text-center" v-if="!list_showable" style=" margin-top:10px">

               <!-- ==============================Save Show =================== -->
               
               <button 
                   v-if="save_btn" 
                   class=" btn-action-bar"
                   type="button"   
                   @click="voided()">Auto Save
               </button>
               <button 
                   v-if="save_btn" 
                   class=" btn-action-bar"
                   type="button"   
                   @click="save_stay(3)">Save & New
               </button>

               <button 
                   v-if="save_btn" 
                   class=" btn-action-bar"
                   type="button"   
                   @click="save_stay(2)" >Save & Out 
               </button>

               <button 
                   v-if="save_btn" 
                   class=" btn-action-bar"   
                   type="button"  
                   @click="save_as_pdf()">Save as PDF
               </button>
               <!-- ==============================Print Show =================== -->

               <button
                   v-if="print_btn" 
                   type="button" 
                   class=" btn-action-bar" 
                   @click="print_priview()">Preview </button>
             
               <button 
                   v-if="print_btn"
                   type="button" 
                   class="btn-action-bar" 
                   @click="print_pdf()">Print
               </button>

              

               <!-- ==============================Posting Status =================== -->
               
               <button 
                   v-if="posting_status_btn" 
                   class=" btn-action-bar"
                   type="button"   
                   @click="posting_status_details(1)">Saved ({{this.posting_status_data.saved}})
               </button>

               <button 
                   v-if="posting_status_btn" 
                   class=" btn-action-bar"
                   type="button"   
                   @click="posting_status_details(2)" >Rejected({{this.posting_status_data.rejected}})
               </button>
               <button 
                   v-if="posting_status_btn" 
                   class=" btn-action-bar"
                   type="button"   
                   @click="posting_status_details(3)">Transmited out ({{this.posting_status_data.transmit_out}})
               </button>

               <button 
                   v-if="posting_status_btn" 
                   class=" btn-action-bar"   
                   type="button"  
                   @click="posting_status_details(4)">Voided({{this.posting_status_data.voided}})
               </button>

               <button    
                   v-if="posting_status_btn" 
                   class=" btn-action-bar"   
                   type="button" 
                   @click="posting_status_details(5)">Posted({{this.posting_status_data.posted}})
               </button>
               <button 
                   v-if="posting_status_btn" 
                   class=" btn-action-bar"   
                   type="button" 
                   @click="posting_status_details(6)">Adjusted({{this.posting_status_data.adjusted}})
               </button>
               <button 
                   v-if="posting_status_btn" 
                   class=" btn-action-bar"   
                   type="button" 
                   @click="posting_status_details(7)">Reposted({{this.posting_status_data.reposted}})
               </button>

             
           </div>

           <div v-if="list_showable" class="form-card">
               
               <div class="pull-right" style="margin:10px 0;">
                   <a  id="excel_view" href="" style="text-decoration:none">
                       <button 
                           :disabled="form.busy"  
                           type="button" 
                           class="btn btn-light btn-print" 
                           style="min-width:90px" >
                           <span class="glyphicon glyphicon-export"></span>
                           Export
                       </button> 
                   </a>
                   <button 
                       :disabled="form.busy"  
                       type="button" 
                       class="btn btn-light btn-print" 
                       @click="print_data()"
                       style="min-width:90px" >
                       <span class="glyphicon glyphicon-print"></span>
                       Print
                   </button> 
                </div>
                <div class="mb-2">
                   <input type="text" v-model="filter" class="form-control table-filter" placeholder="Search..." style="width:400px;"/>
                </div>
                <vue3-datatable :rows="rows" :columns="columns" :search="filter" :sortable="true" rowClass="cursor-pointer" class="whitespace-nowrap">
            
                    <template #sl="data">
                        <strong class="text-info">{{ data.value.sl }}</strong>
                    </template>
                    <template #issue_date="data">
                        <span class="font-semibold">{{ data.value.meeting_date }}</span>
                    </template>
                    <template #issued_by="data">
                        <span class="font-semibold">
                           
                            <img style="border-radius:50% ;" :src="data.value.photo_path" alt="Uploaded Photo" width="50" height="50" />
                            {{ data.value.issued_by }}
                        </span>
                    </template>
                    <template #title="data">
                        <span class="font-semibold">{{ data.value.title }}</span>
                    </template>
                    <template #subject="data">
                        <span class="font-semibold">{{ data.value.subject }}</span>
                    </template>
                    <template #required_action="data">
                        <span class="font-semibold">{{ data.value.required_action }}</span>
                    </template>
                    <template #status_string="data">
                        <span class="font-semibold">{{ data.value.status_string }}</span>
                    </template>
                    
                    <template #buttons="data">
                        <button 
                            class="btn " 
                            style="padding:.17rem .25rem" 
                            @click.prevent="editMeeting(data.value.id)">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                        <button  
                            class="btn "
                            style="padding:.17rem .25rem"
                            @click.prevent="deleteMeeting(data.value.id)">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                        <button  
                            class="btn "
                            style="padding:.17rem .15rem"
                            @click.prevent="deleteMeeting(data.value.id)">
                            <span class="glyphicon glyphicon-print"></span>
                        </button> 
                    </template>
                </vue3-datatable>
            </div>
           <div class="card"> 
               <form 
                   id="msform" 
                   @submit.prevent="editmode ? updateMeeting() : createMeeting()" 
                   @keydown="form.onKeydown($event)">  
                  
                   <div id="content">

                       <div class="form-card" v-if="!list_showable" style="width:90%; padding-left:10%;">
                           <div class="form-folder" id="main_content">
                               <h3 style=" height: 50px;">
                                    <span class="text-left text-white" style="float: left; height: 50px;"> New Meeting</span>
                                    <span 
                                        class="text-left text-white" 
                                        style="float: right; height: 50px; font-size: 14px;"
                                        v-if="editmode">
                                        Posting Status: {{ form.posting_status_string }} <br/>
                                        Posting Date: {{ form.posting_date }} &nbsp; Posting Time: {{ form.posting_time }}
                                    </span>
                                </h3>
                                <div class="form-holder"  >
                                   <div class="form-box-outer">
                                        <h3 class="mt-0">Info</h3>
                                       <div class="row align-self-stretch px-4">
                                           <div class="col-md-6  col-sm-6 col-xs-12"> 
                                                
                                               <label class="fieldlabels ">ID No:</label> 
                                                <input type="text" 
                                                   id="system_no" 
                                                   name="system_no" 
                                                   v-model="form.system_no"  
                                                   placeholder="ID No" disabled/> 

                                                <label class="fieldlabels">Meeting Title<span class="mandatory-field"> *</span>:</label> 
                                                <input type="text" 
                                                   id="title" 
                                                   name="title" 
                                                   v-model="form.title" 
                                                   :class="{ 'is-invalid': form.errors.has('title') }" 
                                                   placeholder="Type Meeting Title" />   
                                                  
                                                <label class="fieldlabels">Subject<span class="mandatory-field"> *</span>:</label> 
                                                <input type="text" 
                                                   id="subject" 
                                                   name="subject" 
                                                   v-model="form.subject" 
                                                   :class="{ 'is-invalid': form.errors.has('subject') }" 
                                                   placeholder="Type Subject" />   
                                                   
                                               
                                                <label class="fieldlabels">Participants<span class="mandatory-field"> *</span>:</label> 
                                                <div>
                                                    <multiselect 
                                                        v-model="form.participants"
                                                        :options="participant_arr"
                                                        :multiple="true"
                                                        placeholder="Select options"
                                                        label="name"
                                                        track-by="id"
                                                        :class="{ 'is-invalid': form.errors.has('participants') }"
                                                    />
                                                  
                                                </div>

                                                <label class="fieldlabels">Priority<span class="mandatory-field"> *</span>:</label> 
                                                <select v-model="form.priority"
                                                    name="priority" 
                                                    class="custom-select" 
                                                    :class="{ 'is-invalid': form.errors.has('priority') }">
                                                    <option disabled value="">--Select-- </option>
                                                    <option value="1">Normal</option>
                                                    <option value="2">Low</option> 
                                                    <option value="3">Medium</option>
                                                    <option value="4">High</option>
                                                    <option value="5">Critical</option>
                                                    
                                                </select>

                                                <label class="fieldlabels">Notification Method<span class="mandatory-field"> *</span>:</label> 
                                                <div class="form-group">

                                                    <select v-model="form.notification_method"
                                                        name="notification_method" 
                                                        class="custom-select" 
                                                        @change="change_notification_method"
                                                        :class="{ 'is-invalid': form.errors.has('notification_method') }">
                                                        <option disabled value="">--Select-- </option>
                                                        <option value="1">SMS</option>
                                                        <option value="2">Email</option> 
                                                        <option value="3">Phone Call</option>
                                                        <option value="4">Other (Please Specify)</option>  
                                                        
                                                    </select>
                                                
                                                    <template v-if="notification_text_enable">
                                                        <label class="fieldlabels"> Notification( Please Specify)<span class="mandatory-field"> *</span>:</label> 
                                                        <input type="text" 
                                                        id="other_notification" 
                                                        name="other_notification" 
                                                        v-model="form.other_notification" 
                                                        :class="{ 'is-invalid': form.errors.has('other_notification') }" 
                                                        placeholder="Type Notification Method" />   
                                                    
                                                    </template>

                                                </div>
                                                
                                                <label class="fieldlabels ">Required Before Meeting<span class="mandatory-field"> *</span>:</label>
                                                <textarea 
                                                    v-model="form.required_action"
                                                    style="height:70px;"
                                                    id="required_action" 
                                                    name="required_action" 
                                                    rows="4" 
                                                    cols="50"
                                                    placeholder="Type Required Before Meeting" 
                                                    :class="{ 'is-invalid': form.errors.has('required_action') }">
                                                </textarea>                                               
                                           </div>
                                           <div class="col-md-6 col-sm-6 col-xs-12"> 
                                                
                                                <label class="fieldlabelText">Date <span class="mandatory-field">*</span>:</label> 
                                                <!-- <input type="date" v-model="form.meeting_date"  @change="formatDateAndSave"/>  -->
                                                
                                                <Vue3datepicker 
                                                    v-model                 ="form.meeting_date" 
                                                    inputFormat="EE dd, MMM  yyyy"
                                                    :class="{ 'is-invalid': form.errors.has('meeting_date') }"
                                                    :enable-time-picker     = "false"
		                                            :clearable              = "false"
		                                            :month-change-on-scroll = "false"
                                                    :typeable               ="false"
		                                            auto-apply>
                                                </Vue3datepicker>
                                                
                                                <label class="fieldlabelText">Time : &nbsp;&nbsp;{{ form.meeting_time }}</label> <br/> 
                                                <vue-timepicker  v-model="form.meeting_time" format="hh:mm:ss A"
                                                    :class="{ 'is-invalid': form.errors.has('meeting_time') }"
                                                    :manual-input="true" :minute-interval="15" style="width:100%"/>
                                               <label class="fieldlabels ">Location<span class="mandatory-field"> *</span>:</label>
                                                <textarea 
                                                    v-model="form.location"
                                                    style="height:70px;"
                                                    id="location" 
                                                    name="location" 
                                                    rows="4" 
                                                    cols="50"
                                                    placeholder="Type Location" 
                                                    :class="{ 'is-invalid': form.errors.has('location') }">
                                                </textarea>
                                                <label class="fieldlabels">Location Link:</label> 
                                                <input type="text" 
                                                   id="location_link" 
                                                   name="location_link" 
                                                   v-model="form.location_link" 
                                                   :class="{ 'is-invalid': form.errors.has('location_link') }" 
                                                   placeholder="Type Location Link" /> 
                                                <label class="fieldlabels">Upload File:</label>
                                                <div
                                                    class="upload-container"
                                                    @dragover.prevent="dragging = true"
                                                    @dragleave.prevent="dragging = false"
                                                    @drop.prevent="handleDrop"
                                                >
                                                    <div v-if="form.file_id==0" class="upload-placeholder" :class="{ dragging }">
                                                        <p>Drag and drop a File or</p>
                                                        <input
                                                            type="file"
                                                            ref="fileInput"
                                                            @change="handleFileChange"
                                                            class="file-input"
                                                        />
                                                        <button @click="browseFile" type="button">Browse</button>
                                                    </div>
                                                    <div v-else class="preview">
                                                        <span>{{ file_name }}</span><br/>
                                                        <button @click="removeFile" type="button">Remove</button> &nbsp;
                                                        <button  type="button">
                                                            <a :href="fileUrl"  target="_blank">Download</a>
                                                        </button>
                                                    </div>
                                                </div>
                                                <label class="fieldlabels">Comment :</label> 
                                                <textarea 
                                                    v-model="form.comments"
                                                    style="height:70px;"
                                                    id="comments" 
                                                    name="comments" 
                                                    rows="8" 
                                                    cols="100"
                                                    placeholder="Type Comments" 
                                                    :class="{ 'is-invalid': form.errors.has('comments') }">
                                                </textarea>
                                           </div>
                                       </div>
                                       
                                   </div>

                                   <div class="form-box-outer mt-4">
                                        <div class="row">
                                            <div class="col-md-12  col-sm-12 col-xs-12">
                                                <table class="table" style="width: 100%;">
                                                    <thead>
                                                        <tr class="">
                                                            <th width="40%">Reminder</th>
                                                            <th width="35%">Date</th>
                                                            <th width="25%">Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody >
                                                        <tr >
                                                            <td>1st Reminder</td>
                                                            <td>
                                                                <Vue3datepicker 
                                                                    v-model="form.first_reminder_date" 
                                                                    :format="dateformat" 
                                                                    :class="{ 'is-invalid': form.errors.has('first_reminder_date') }"/>
                                                            </td>
                                                            <td>
                                                                <vue-timepicker  v-model="form.first_reminder_time" format="hh:mm:ss A"
                                                                    :class="{ 'is-invalid': form.errors.has('first_reminder_time') }"
                                                                    :manual-input="true" :minute-interval="15" style="width:100%"/>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>2nd Reminder</td>
                                                            <td>
                                                                <Vue3datepicker 
                                                                    v-model="form.second_reminder_date" 
                                                                    :format="dateformat" 
                                                                    :class="{ 'is-invalid': form.errors.has('second_reminder_date') }"/>
                                                            </td>
                                                            <td>
                                                                <vue-timepicker  v-model="form.second_reminder_time" format="hh:mm:ss A"
                                                                    :class="{ 'is-invalid': form.errors.has('second_reminder_time') }"
                                                                    :manual-input="true" :minute-interval="15" style="width:100%"/>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                   </div>
                                   

                                   <div class="form-box-outer mt-4">
                                        <h3 class="my-0 text-left">Next Meeting Date & Time</h3>
                                        <div class="row py-0 px-0">
                                            <div class="col-md-12  col-sm-12 col-xs-12">
                                                <table class="table" style="width: 80%;">
                                                   
                                                    <tbody>
                                                        <tr>
                                                            
                                                            <td>
                                                                <label class="fieldlabelText">Date :</label> 
                                                                <Vue3datepicker 
                                                                    v-model="form.next_meeting_date" 
                                                                    :format="dateformat" 
                                                                    :class="{ 'is-invalid': form.errors.has('next_meeting_date') }"/>
                                                            </td>
                                                            <td>
                                                                <label class="fieldlabelText">Time :</label> 
                                                                <vue-timepicker  v-model="form.first_reminder_time" format="hh:mm:ss A"
                                                                    :class="{ 'is-invalid': form.errors.has('first_reminder_time') }"
                                                                    :manual-input="true" :minute-interval="15" style="width:100%"/>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                   </div>
                               </div>
                            </div> 
                            
                            


                            <div class="text-right" v-if="!list_showable" style=" margin-top:40px">
                               <button 
                                   v-if="data_entry"
                                   :disabled="form.busy || editmode==false"  type="button" class="btn btn-sm btn-primary" 
                                   style="min-width:70px" 
                                   @click="reset_form()">New </button>
                             
                               <button 
                                   v-if="data_entry"
                                   :disabled="form.busy || editmode==true || form.posting_status!=0 "  
                                   type="button" 
                                   class="btn btn-sm  btn-primary" 
                                   style="min-width:70px"  
                                   @click="save_stay(1)">Save</button>

                               <button 
                                   v-if="data_entry"
                                   :disabled="form.busy || editmode==false || form.posting_status!=0"  
                                   type="submit" 
                                   class="btn btn-sm  btn-primary" 
                                   style="min-width:70px" >Update</button>

                               <button 
                                   v-if="data_entry"
                                   :disabled="form.busy || editmode==false || form.posting_status!=0"  type="button" 
                                   class="btn btn-sm  btn-primary" 
                                   style="min-width:70px"  @click.prevent="deleteMeeting()">Delete</button>
                              
                               <button 
                                   v-if="data_entry"
                                   :disabled="form.busy || editmode==false || form.posting_status!=0" 
                                   type="button" 
                                   class="btn btn-sm  btn-primary" 
                                   style="min-width:70px"  
                                   @click="transmit()" >Transmit </button>

                               <button 
                                   v-if="approval_btn"
                                   :disabled="form.busy || editmode==false  || user_type!=9 || form.posting_status!=1"  
                                   type="button" 
                                   class="btn btn-sm  btn-primary" 
                                   style="min-width:70px"  
                                   @click="rejected()" >Reject </button>
                               <button 
                                   v-if="approval_btn"
                                   :disabled="form.busy || editmode==false  || user_type!=9 || form.posting_status!=1"  
                                   type="button" 
                                   class="btn btn-sm  btn-primary" 
                                   style="min-width:70px"  
                                   @click="voided()">Void</button>

                               <button 
                                   v-if="approval_btn"
                                   :disabled="form.busy || editmode==false || user_type!=9 || form.posting_status!=1"  
                                   type="button" 
                                   class="btn btn-sm btn-primary" 
                                   style="min-width:110px"  
                                   @click="post()" >Post </button>

                               <button
                                   v-if="approval_btn" 
                                   :disabled="form.busy || form.posting_status<2 || user_type!=9"  type="button" 
                                   class="btn btn-sm  btn-primary" 
                                   style="min-width:70px"  
                                   @click="adjust()">Adjust</button>

                               <button 
                                   v-if="approval_btn"
                                   :disabled="form.busy || form.posting_status!=3 || user_type!=9"  type="button" 
                                   class="btn btn-sm  btn-primary" 
                                   style="min-width:70px" 
                                   @click="repost()">Repost</button>
                            
                           </div> 
                       </div> 
                   </div> 
                    
               </form>
                   
                   <div id="hidden_exceldata"  style="display:none"></div>
           </div> 
   </fieldset> 
</template>
<style>
     .upload-container {
      border: 2px dashed #ccc;
      padding: 20px;
      text-align: center;
      cursor: pointer;
      position: relative;
    }

    .upload-placeholder {
      color: #999;
    }

    .upload-placeholder.dragging {
      background-color: #f0f8ff;
    }

    .file-input {
      display: none;
    }

    .preview img {
      max-width: 50%;
      height: auto;
      display: block;
      margin: 0 auto 10px;
    }
    .multiselect {
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    /* .thead-none thead{
		display: block !important;

    } */

</style>

<script>
    import { ref, watch, onMounted } from "vue";
    import { format } from "date-fns";
   import Vue3Datatable from "@bhplugin/vue3-datatable";
   import "@bhplugin/vue3-datatable/dist/style.css";
   import Multiselect from "vue-multiselect";
   import "vue-multiselect/dist/vue-multiselect.min.css";
   import VueTimepicker from 'vue3-timepicker';
    import 'vue3-timepicker/dist/VueTimepicker.css';
    import Vue3datepicker from "vue3-datepicker";
   
   import html2pdf from "html2pdf.js";
   import { jsPDF } from "jspdf";
   import "jspdf-autotable"; // For advanced table formatting

   export default {
       name:'list-product-categories',
       components:{
            Vue3Datatable,
            Multiselect,
            Vue3datepicker,
            VueTimepicker
       },
       data(){
            
           return{
                
            dragging: false, 
               editmode       :false,
               filter         : '',
               data_entry     :true,
               approval_btn   :false,
               save_btn       :false,
               print_btn      :false,
               list_btn       :false,
               posting_status_btn:false,
               favorite_btn   :false,
               list_showable  :false,
               pdf_show_moment:false,
               form:new Form({ 
                    system_no:'',                  
                    comments:'', 
                    id:'', 
                    title:'',
                    subject:'',
                    meeting_type:'',
                    issued_by:'',
                    issued_by_id:'',
                    posting_status:'',
                    participants: [], 
                    priority:"",
                    location:'',
                    location_link:'',
                    required_action:'',
                    other_notification:'',
                    notification_method:'',
                    meeting_date:new Date(),
                    meeting_time:null,
                    posting_date:null,
                    posting_time:null,
                    posting_status_string:null,
                    file_id:0,
               }),
               participant_arr: [],
              
              // dateformat: "dd-MM-yyyy", // Ensure valid format
               user_type:'',
               report_type:0,
                columns:ref( [
                    { title: 'SL', field: 'sl', align: 'center' },
                    { title: 'No', field: 'system_no' },
                    { title: 'Meeting Date', field: 'meeting_date' },
                    { title: 'Issue By', field: 'issued_by' },
                    { title: 'Title', field: 'title' },
                    { title: 'Subject', field: 'subject' },
                    { title: 'Required Action', field: 'required_action' },
                    { title: 'Status', field: 'status_string' },
                    { title: 'Action', field: 'buttons', sortable: false },
                ]),
                rows: [],
                posting_status_data:[],
                page: 1,
                per_page:15,
                expanded: null,
                file: null,
                fileUrl: null,
                file_name:null, 
                notification_text_enable:false,
           }
       },
       
       created: function()
       {
           this.fetchMeeting();
          
       },
       
       methods: {

            formatDateAndSave(){
              // let formattedDate.value = format(new Date(this.meeting_ddateInput.value), "EEE d, MMM yyyy");
            },
            dateformat()
            {
                alert();
            },
            change_notification_method()
            {  
              if(this.form.notification_method==4)
              {
                this.notification_text_enable=true;
              }
              else{
                this.notification_text_enable=false;
              }
             
            },
            async uploadFile(file) {
                const formData = new FormData();
                formData.append("file", file);

                try {
                    const response = await axios.post("/upload-file", formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                    });
                    this.fileUrl = response.data.path;
                    this.file_name = response.data.filename;
                    this.file = file;
                    this.form.file_id=response.data.image_id;
                } catch (error) {
                    showToast('Upload failed.', 'error');
                    console.error(error);
            }
            },
            handleDrop(event) {
                this.dragging = false;
                const file = event.dataTransfer.files[0];
                if (file) this.uploadFile(file);
            },


            handleFileChange(event) {
                const file = event.target.files[0];
                if (file) this.uploadFile(file);
            },

            browseFile() {
                this.$refs.fileInput.click();
            },
            removeFile() {
                this.file = null;
                this.fileUrl = null;
            },
           
            
            print_priview()
            {
               let uri = '/Meeting/'+this.form.id;
               window.axios.get(uri).then((response) => {
       
                   var w = window.open("Surprise", "#");
                   var d = w.document.open();
                   d.write(response.data);                 
                   d.close();
               });

           },
          
           print_data()
           {
               let uri = '/MeetingPrintAll/'+this.report_type+'/1';
               window.axios.get(uri).then((response) => {
       
                   var w = window.open("Surprise", "#");
                   var d = w.document.open();
                   d.write(response.data);                 
                   d.close();
               });
           },
           print_pdf()
           {
               let uri = '/MeetingPrintPdf/'+this.form.id;
               window.axios.get(uri).then((response) => {

                  // document.getElementById("table-container").innerHTML = response.data;
                   this.pdf_show_moment=true;
                   const doc = new jsPDF({
                       orientation: "landscape", // Adjust orientation if needed
                       unit: "pt", // Set unit to points for precise control
                       format: "a4", // Standard page size
                   });
                   doc.setFontSize(8);
                   doc.html(response.data, {
                       callback: function (pdf) {
                           pdf.save("bank_info.pdf");
                       },
                       x: 0,
                       y: 0,
                   });
               });
               this.pdf_show_moment=false;
           },

           
           approval_show()
           {
               if(this.approval_btn) this.approval_btn=false;
               else 
               {
                   this.data_entry         =false;
                   this.approval_btn       =true;
                   this.save_btn           =false;
                   this.print_btn          =false;
                   this.posting_status_btn =false;
                   this.list_btn           =false;
               }
           },
           btn_print()
           {
               if(this.print_btn) this.print_btn=false;
               else 
               {
                   this.save_btn           =false;
                   this.print_btn          =true;
                   this.posting_status_btn =false;
                   this.list_btn           =false;
                  
               }
           },

           data_enty_show()
           {
               if(this.data_entry) this.data_entry=false;
               else 
               {
                   this.data_entry         =true;
                   this.approval_btn       =false;
                   this.save_btn           =false;
                   this.print_btn          =false;
                   this.posting_status_btn =false;
                   this.list_btn           =false;
                   this.reset_form();

               }
           },


           save_show()
           {
               if(this.save_btn) this.save_btn=false;
               else 
               {
                   this.save_btn           =true;
                   this.print_btn          =false;
                   this.posting_status_btn =false;
                   this.approval_btn       =false;
                   this.list_btn           =false;
               }
           },
                    
           posting_status_show()
           {
               if(this.posting_status_btn) this.posting_status_btn=false;
               else 
               {
                   let uri = '/MeetingPostingStatus';
                   window.axios.get(uri).then((response) => {
                       this.posting_status_data = response.data.meeting_list;
                   });
                   this.save_btn           =false;
                   this.print_btn          =false;
                   this.posting_status_btn =true;
                   this.data_entry         =false;
                   this.approval_btn       =false;
                   this.list_btn           =false;
                   this.list_showable      =false;
               }
           },

           posting_status_details(type)
           {
               this.save_btn           =false;
               this.print_btn          =false;
               this.posting_status_btn =false;
               this.approval_btn       =false;
               this.data_entry         =false;
               this.list_btn           =true;
               this.form.reset();
               this.editmode=false;
               let uri = '/MeetingPostingType/'+type;
               window.axios.get(uri).then((response) => {
                   this.rows = response.data.meeting_send_list;
               });
               this.list_showable=true;
               this.report_type=type;

            //    let uri1 = '/MeetingPrintAll/'+this.report_type+'/2';
            //    window.axios.get(uri1).then((response) => {
       
            //        document.getElementById("hidden_exceldata").innerHTML = response.data;
            //        $('#excel_view').attr("href", $('#download_excel').attr('href'));
            //    });
           },


           
           reset_form()
           {

               this.form.reset ();
               this.editmode=false;
               this.list_showable=false;
               this.fetchMeeting();
               
           },
           reset_list()
           {

               this.save_btn           =false;
               this.print_btn          =false;
               this.posting_status_btn =false;
               this.approval_btn       =false;
               this.data_entry         =false;
               this.list_btn           =true;
               this.form.reset();
               this.editmode=false;
               let uri = '/MeetingList';
               window.axios.get(uri).then((response) => {
                   this.rows = response.data.meeting_send_list;
               });
               this.list_showable=true;
               this.report_type=0;
            //    let uri1 = '/MeetingPrintAll/'+this.report_type+'/2';
            //    window.axios.get(uri1).then((response) => {
       
            //        document.getElementById("hidden_exceldata").innerHTML = response.data;
            //        $('#excel_view').attr("href", $('#download_excel').attr('href'));
            //    });
           }, 
           

           
            fetchMeeting()
            {
                let uri = '/Meetings';
                window.axios.get(uri).then((response) => {
                    this.rows                           =response.data.meeting_send_list;
                    this.participant_arr                =response.data.participant_arr;
                    this.form.issued_by                 =response.data.issued_by	;
                    this.form.issued_by_id              =response.data.issued_by_id;
                
                }); 
            },
        
      

           updateMeeting()
           {
               
               this.form.put('/Meetings/'+this.form.id).then(({ data })=>{
                       var response_data=data.split("**");
                       if(response_data[0]*1==1)
                       {
                          
                           showToast('Data Update Successfully', 'success');
                           this.editMeeting(response_data[1]);
                           this.editmode=true;

                       }
                       else{

                           showToast('Invalid Operation', 'error');
                       }
                   })
                   .catch(()=>{
                      showToast("there was some wrong","warning");
               
                   });
           },


           
           createMeeting()
           {

               this.form.post('/Meetings') .then(({ data }) => { 
                                
                   showToast('Data Save Successfully', 'success');
                   this.form.reset ();
                   this.fetchMeeting();
               })
           },

          

           save_stay(type){
                //this.fomated_time();
                //alert(this.form.formated_meeting_time;
                this.form.post('/Meetings') .then(({ data }) => { 
                   var response_data=data.split("**");
                       
                        if (response_data[0] * 1 == 1) {
                           showToast('Data Save Successfully', 'success');

                           if (type == 1) {
                               this.fetchMeeting(response_data[1]);
                               this.editmode = true;
                           } else if (type == 2) {
                               window.location.href = '/Dashboard';

                           } else if (type == 3) {
                               this.form.reset();
                               this.fetchMeeting();
                           }
                           } else if (response_data[0] * 1 == 10) {
                               showToast("Please open the 'Open File' ", 'error');
                       } else {

                           showToast('Invalid Operation', 'error');
                       }      
                   
               })
           },
           deleteMeeting()
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

                     this.form.delete('/Meetings/'+this.form.id).then(()=>{
                       
                         if(result.value) {
                              showAlert(
                               'Deleted!',
                               'Your Announcement has been deleted.',
                               'success'
                             );
                            this.form.reset();
                            this.fetchMeeting();
                         }            

                     }).catch(()=>{

                       showAlert("failed!","there was some wrong","warning");
                 });
              
             })
           },
           

           transmit()
           { 
               this.form.posting_status=1;

               Swal.fire({
                   title: 'Are you sure?',
                   text: "You won't be able to revert this!",
                   type: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Yes, Transmit it!'
               }).then((result) => {

                   this.form.post('/MeetingPost/'+this.form.id).then((response)=>{
                       
                       var response_data=response.data.split("**");
                       if(response_data[0]==1)
                       { 
                           showAlert(
                               'Transmited!',
                               'Your Data has been Transmited.',
                               'success'
                           );

                           this.editMeeting(response_data[1]);
                   
                       }            

                   }).catch(()=>{
                       showAlert("failed!","there was some wrong","warning");
                   });
                   
               })
               
           },
           rejected()
           { 
               
               Swal.fire({
                   title: 'Are you sure?',
                   text: "You won't be able to revert this!",
                   type: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Yes, Reject it!'
               }).then((result) => {

                   this.form.post('/MeetingReject/'+this.form.id).then((response)=>{
                       
                       var response_data=response.data.split("**");
                       if(response_data[0]==1)
                       { 
                           showAlert(
                               'Rejected!',
                               'Your Data has been Rejected.',
                               'success'
                           );
                           this.fetchMeeting();
                       }            

                   }).catch(()=>{
                       showAlert("failed!","there was some wrong","warning");
                   });
                   
               })
               
           },

           voided()
           {

               Swal.fire({
                   title: 'Are you sure?',
                   text: "You won't be able to revert this!",
                   type: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Yes, Void it!'
               }).then((result) => {

                   this.form.post('/MeetingVoid/'+this.form.id).then((response)=>{
                       
                       var response_data=response.data.split("**");
                       if(response_data[0]==1)
                       { 
                           showAlert(
                               'Void!',
                               'Your Data has been Voided.',
                               'success'
                           );

                           this.editMeeting(response_data[1]);
                   
                       }            

                   }).catch(()=>{
                       showAlert("failed!","there was some wrong","warning");
                   });
                   
               })
           },
           post()
           { 
               this.form.posting_status=2;
               
               Swal.fire({
                   title: 'Are you sure?',
                   text: "You won't be able to revert this!",
                   type: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Yes, Post it!'
               }).then((result) => {

                   this.form.post('/MeetingPost/'+this.form.id).then((response)=>{
                       
                       var response_data=response.data.split("**");
                       if(response_data[0]==1)
                       { 
                           showAlert(
                               'Posted!',
                               'Your Data has been Posted.',
                               'success'
                           );
                          // this.editMeetingDistribution(response_data[1]);
                           this.editMeeting(response_data[1]);
                   
                       }            

                   }).catch(()=>{
                       showAlert("failed!","there was some wrong","warning");
                   });
                   
               })
               
           },

           repost()
           {            
               Swal.fire({
                   title: 'Are you sure?',
                   text: "You won't be able to revert this!",
                   type: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Yes, Repost it!'
               }).then((result) => {


                   this.form.post('/MeetingRepost/'+this.form.id).then((response)=>{
                       
                       var response_data=response.data.split("**");
                       if(response_data[0]==1)
                       { 
                           showAlert(
                               'Posted!',
                               'Your Data has been Reposted.',
                               'success'
                           );
                           
                           this.editMeeting(response_data[1]);
                       }            

                   }).catch(()=>{
                       showAlert("failed!","there was some wrong","warning");
                   });
                   
               })
               
           },

           adjust()
           { 
               
               this.form.post('/adjustMeeting/'+this.form.id).then((response)=>{
                   var response_data=response.data.split("**");
                   if(response_data[0]==1)
                   {
                       showToast('Data Update Successfully', 'success');
                       
                       this.editMeeting(response_data[1]);
                       
                       this.editmode=true;
                   }
                   else{

                       showToast('Invalid Operation', 'error');
                   }
               }).catch(()=>{
                       showAlert("failed!","there was some wrong","warning");
                   });             
               
           },
           editMeeting(id)
           {


               this.form.reset();
               this.list_showable=false;
               let uri = '/Meetings/'+id+'/edit';
               window.axios.get(uri).then((response) => {
                   
                    this.user_type                          =response.data.user_type;
                    this.form.id                            =response.data.meeting_send_list.id;
                    this.form.system_no                   	=response.data.meeting_send_list.system_no;

                    
                    this.form.status                    	=response.data.meeting_send_list.status;
                    this.form.issued_by                  	=response.data.meeting_send_list.issued_by;
                    this.form.priority            			=response.data.meeting_send_list.priority;
                    //this.form.rejection_cause               =response.data.meeting_send_list.rejection_cause;
                    this.form.location                      =response.data.meeting_send_list.location;
                    this.form.location_link                 =response.data.meeting_send_list.location_link;
                    this.form.issue_to                      =response.data.meeting_send_list.issue_to;
                    this.form.participants                  =response.data.meeting_send_list.participants;
                    this.form.subject                  		=response.data.meeting_send_list.subject;
                    this.form.title                         =response.data.meeting_send_list.title;
                    this.form.required_action               =response.data.meeting_send_list.required_action;
                    this.form.priority                      =response.data.meeting_send_list.priority;
                    this.form.notification_method           =response.data.meeting_send_list.notification_method;
                    
                    this.form.posting_status            	=response.data.meeting_send_list.posting_status;
                    this.form.comments                      =response.data.meeting_send_list.comments; 
                    this.form.file_id                       =response.data.meeting_send_list.file_id; 
                    this.fileUrl                            =response.data.meeting_send_list.file_path;  
                    this.file_name                          =response.data.meeting_send_list.file_name;   
                    this.form.posting_status_string         =response.data.meeting_send_list.posting_status_string;
                    this.form.meeting_date                  =new Date(response.data.meeting_send_list.meeting_date);
                    this.form.meeting_time                  ={
                        'hh': response.data.meeting_send_list.meeting_time.hh,
                        'mm': response.data.meeting_send_list.meeting_time.mm,
                        'ss': response.data.meeting_send_list.meeting_time.ss,
                        'A': response.data.meeting_send_list.meeting_time.A,
                        
                    };
                   
                    console.log(this.form.meeting_time);
                    
                    if(response.data.meeting_send_list.first_reminder_date)
                        this.form.first_reminder_date       =new Date(response.data.meeting_send_list.first_reminder_date);
                    else
                        this.form.first_reminder_date       =null;

                    if(response.data.meeting_send_list.second_reminder_date)
                        this.form.second_reminder_date       =new Date(response.data.meeting_send_list.second_reminder_date);
                    else
                        this.form.second_reminder_date       =null;
                    

                    if(response.data.meeting_send_list.next_meeting_date)
                        this.form.next_meeting_date         =new Date(response.data.meeting_send_list.next_meeting_date);
                    else
                        this.form.next_meeting_date         =null;
                    

                    this.form.second_reminder_time          =response.data.meeting_send_list.second_reminder_time;
                    this.form.first_reminder_time           =response.data.meeting_send_list.first_reminder_time;
                    this.form.next_meeting_time             =response.data.meeting_send_list.next_meeting_time;
                    this.form.posting_time                  =response.data.meeting_send_list.posting_time;
                    this.form.posting_date                  =response.data.meeting_send_list.posting_date;
                    this.editmode=true;
                    //this.startIssueTimeUpdater();
                    

                    if(this.form.posting_status>=1)
                    {
                       this.approval_btn=true
                       this.data_entry  =false
                       this.print_btn   =false
                       this.save_btn    =false
                       this.posting_status_btn=false
                   }
                   else{
                       this.approval_btn=false
                       this.data_entry  =true
                       this.print_btn   =false
                       this.save_btn    =false
                       this.posting_status_btn=false
                   }
                   this.list_btn=false
                   
               });                 
           },
       }
   }  
   
</script>