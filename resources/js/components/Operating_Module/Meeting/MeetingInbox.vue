<template>
    <fieldset>
           <h4 class="breadcumb"> Meeting/Inbox</h4>
           <p class="breadcumb-p">Operation Modules/Administrative/Meeting</p>

           
           <div class="card"> 
						
			<form 
				id="msform" 
				@keydown="form.onKeydown($event)">  
				
				<div id="content">

					<div class="form-card" >
						<div class="form-folder" id="main_content">
							
							<div class="form-holder" style="" >
								<div class="form-box-outer">
									<h3>
										<div class="row ">
										
											<div class="col-md-6  col-sm-6 col-xs-12">
												<div class="row ">
										
													<div class="col-md-6  col-sm-6 col-xs-12">
														Meeting Inbox
													</div>
													
													<div class="mb-2 col-md-6  col-sm-6 col-xs-12">
														<input type="text" 
															v-model="filter" 
															class="form-control table-filter"
															placeholder="Search..." 
															style="width:280px;"/>
													</div>
												</div>
											</div>

                                            <div class="col-md-6  col-sm-6 col-xs-12">
												<div class="row ">
										
													<div class="col-md-12  col-sm-12 col-xs-12 text-left" >
                                                         <!-- New -->
                                                         <button 
                                                            title="New" 
                                                            class="btn text-white" 
                                                            style="padding:.17rem .15rem"
                                                            @click.prevent="newMeeting()">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </button> 

                                                        <!-- Inbox -->
                                                        <button 
                                                            title="Inbox" 
                                                            class="btn text-white"
                                                            :class="{'text-white':form.checked==true}"
                                                            style="padding:.17rem .15rem"
                                                            @click.prevent="inboxMeeting()">
                                                            <span class="glyphicon glyphicon-inbox"></span>
                                                        </button> 
                                                        <!-- Send -->
                                                        <button  
                                                            title="Send"
                                                            class="btn text-white"
                                                            :class="{'text-white':form.checked==true}"
                                                            style="padding:.17rem .15rem"
                                                            @click.prevent="sendMeeting()">
                                                            <span class="glyphicon glyphicon-send"></span>
                                                        </button> 

                                                        <button 
                                                            title="Trash" 
                                                            class="btn text-white"
                                                            v-if="form.checked"
                                                            style="padding:.17rem .25rem"
                                                            @click.prevent="trashMeeting()">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </button>

                                                        <button 
                                                            title="Flag" 
                                                            class="btn text-white"
                                                            v-if="form.checked"
                                                            style="padding:.17rem .25rem"
                                                            @click.prevent="flagMeeting()">
                                                            <span class="glyphicon glyphicon-flag"></span>
                                                        </button>

                                                        <button  
                                                            title="Block"
                                                            class="btn text-white"
                                                            v-if="form.checked"
                                                            style="padding:.17rem .15rem"
                                                            @click.prevent="blockMeeting()">
                                                            <span class="glyphicon glyphicon-ban-circle"></span>
                                                        </button> 
                                                        <button  
                                                            title="Rejectd"
                                                            class="btn text-white"
                                                            v-if="form.checked"
                                                            style="padding:.17rem .25rem"
                                                            @click.prevent="rejectedMeeting()">
                                                            <span class="glyphicon glyphicon-remove-circle"></span>
                                                        </button>
                                                        <button 
                                                            title="Archive" 
                                                            class="btn text-white"
                                                            v-if="form.checked"
                                                            style="padding:.17rem .15rem"
                                                            @click.prevent="archiveMeeting()">
                                                            <span class="glyphicon glyphicon-cloud-download"></span>
                                                        </button> 

													</div>
												</div>
											</div>
										</div>
									</h3>
									
									<div class="row align-self-stretch">
										
										<div class="col-md-6  col-sm-6 col-xs-12" style="min-height: 800px; overflow-y: scroll; overflow-x: hidden;">
			
											<div class="form-box-outer">
												
												<vue3-datatable :rows="rows" :columns="columns" :search="filter" :sortable="true"
                                                     rowClass="cursor-pointer" class="advanced-table whitespace-nowrap">
													<template #sl="data" :class="{'display_message':data.value.id==form.id}">	
                                                       												
                                                        <button 
                                                            v-if="data.value.checked" 
                                                            class="btn "
                                                            style="padding:.17rem .25rem"
                                                            @click.prevent="MeetingView(data)">
                                                            <span class="glyphicon glyphicon-check"></span>
                                                        </button>
                                                        <button  
                                                            v-else 
                                                            class="btn "
                                                            style="padding:.17rem .15rem"
                                                            @click.prevent="MeetingView(data)">
                                                            <span class="glyphicon glyphicon-unchecked"></span>
                                                        </button> 
													</template>
													<template #meeting="data" >
                                                        <div 
                                                            class="email-item" 
                                                            @click.prevent="MeetingView(data)" 
                                                            :class="{'display_message':data.value.id==form.id,'read_message':data.value.read}">
                                                            <div class="email-header">
                                                                <div class="d-flex align-items-center">
                                                                    <img style="border-radius:50% ;" :src="data.value.photo_path" alt="Photo" width="40" height="40" />
                                                                    &nbsp;&nbsp; 
                                                                    <span class="email-sender">{{ data.value.issued_by }}</span>
                                                                </div>
                                                                <span class="email-time">{{ data.value.posting_time }} &nbsp; {{ data.value.posting_date }}</span>
                                                            </div>
                                                            <div class="email-subject">Ti: {{ data.value.title }}</div>
                                                            <div class="email-subject">Re: {{ data.value.subject }}</div>
                                                            <div class="email-content">
                                                                {{ data.value.required_action }}....
                                                            </div>
                                                        </div>
													</template>
													
												</vue3-datatable>
											</div>
										</div>
                                        <div class="col-md-6  col-sm-6 col-xs-12 centered-text" v-if="!list_showable" >
                                            <h2>No Message Selected</h2>

                                        </div>
										<div class="col-md-6  col-sm-6 col-xs-12" v-if="list_showable"> 

                                            <div class="container mt-4">
                                                <div class="card mb-3">
                                                    <div class="card-header">Meeting Requested By:</div>
                                                    <div class="card-body">
                                                        <div class="text-end">
                                                            <p>
                                                            
                                                                <img style="border-radius:50% ;"  :src="form.photo_path" alt="Photo" width="40" height="40" />
                                                                <strong class="px-2">Name:</strong>
                                                                {{form.issued_by}}
                                                            </p>
                                                        </div>
                                                        <p><strong>Request Date:</strong> {{ form.posting_date }} <strong class="px-2">Time:</strong>{{ form.posting_time }}</p>
                                                        <p><strong>Comment:</strong> {{ form.comments }} </p>
                                                    </div>
                                                </div>
                                                
                                                <div class="card mb-3">
                                                    <div class="card-header text-center">Meeting Profile</div>
                                                    <div class="card-body">
                                                        <p><strong>Meeting No:</strong> {{ form.system_no }}</p>
                                                        <p><strong>Meeting Title:</strong>  {{ form.title }}</p>
                                                        <p><strong>Type:</strong> {{ form.meeting_type_string }}</p>
                                                        <p><strong>Subject:</strong>{{ form.subject }}</p>
                                                        <p><strong>Location:</strong>{{ form.location }}</p>
                                                        <p><strong>Location Map:</strong> <a :href="form.location_link" target="_blank">{{ form.location_link }}</a></p>
                                                       
                                                        <p class="mt-4"><strong>Priority:</strong> <span class="text-danger">{{ form.priority_string }}</span></p>
                                                        <p><strong>Notification Method:</strong> {{ form.notification_method_string }}</p>
                                                        <p><strong>Meeting Date:</strong> {{ form.meeting_date }}</p>
                                                        <p><strong>Meeting Time:</strong> {{ form.meeting_time }}</p>
                                                        <p><strong>Participants List:</strong> {{ form.participants }}</p>
                                                        <p><strong>Required Before Meeting:</strong> {{ form.required_action }}</p>
                                                        
                                                        <p class="mt-4"><strong>Reminder 1</strong></p>
                                                        <p><strong >Date:</strong> &nbsp;&nbsp;{{ form.first_reminder_date }} <strong class="px-3">Time:</strong> {{ form.first_reminder_time }}</p>

                                                        <p class="mt-4"><strong>Reminder 2</strong></p>
                                                        <p><strong>Date:</strong> &nbsp;&nbsp;{{ form.second_reminder_date }} <strong class="px-3">Time:</strong> {{ form.second_reminder_time }}</p>
                                                        
                                                        <p class="mt-4"><strong>Next Meeting</strong></p>
                                                        <p><strong>Date:</strong> &nbsp;&nbsp;{{ form.next_meeting_date }} <strong class="px-3">Time:</strong> {{ form.next_meeting_time }}</p>
                                                       
                                                    </div>
                                                </div>
                                                
                                                <div class="card">
                                                    <div class="card-header">Acknowledge & Confirmation</div>
                                                    <div class="card-body">
                                                        <div class="email-header">
                                                            <div class="d-flex align-items-center">
                                                                <img style="border-radius:50% ;" :src="form.photo_path" alt="Photo" width="40" height="40" />
                                                                &nbsp;&nbsp;
                                                                <span class="email-sender">{{ form.issued_by }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="email-time"><strong>Date:</strong>{{ form.posting_date }}</span><br/>
                                                                <span class="email-time"><strong>Time:</strong>{{ form.posting_time }}</span><br/>
                                                                <span class="email-time" v-if="form.is_confirm==1"><strong>Confirmed</strong></span>
                                                                <span class="email-time" v-if="form.is_confirm==2"><strong>Denied</strong></span>
                                                            </div>
                                                           
                                                        </div>
                                                       
                                                        <label for="comment" class="form-label">Comment:</label>
                                                        <textarea id="comment" 
                                                            class="form-control" 
                                                            v-model="form.participant_comments"
                                                            rows="5" style="min-height: 50px;"></textarea>
                                                        <div class="mt-3">
                                                            <button 
                                                                :disabled="form.busy || form.is_confirm==1" 
                                                                class="btn  btn-primary mx-2" 
                                                                @click="meeting_confirmation(1)">Confirm</button>
                                                            <button 
                                                                :disabled="form.busy || form.is_confirm==2" 
                                                                class="btn btn-danger" 
                                                                @click="meeting_confirmation(2)">Deny</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                         
																							
										</div>
                                        
										
									</div>
									
								</div>
							
								
							</div>
						</div> 
						

					</div> 
				</div> 
					
			</form>				
                
        </div> 
   </fieldset> 
</template>
<style>
    
    .multiselect {
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .advanced-table table thead {
		display: none !important;
	}

    .email-item {
        border: 1px solid #ddd;
        border-radius: 5px; 
        padding: 5px;
        margin: 5px 0;
        background-color: #B9B9B940;

    }
    .email-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .email-subject {
        font-weight: bold;
    }
    .email-content {
        color: #000;
    }
    .checkbox {
        margin-right: 10px;
    }

    .cursor-pointer{
        border-bottom: 1px solid #B9B9B9 !important;
        background-color: #B9B9B9 !important;
    
    }
    .centered-text {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        min-height: 600px;
    }
    
    .bh-table-responsive table tbody tr td{
        padding:.25rem .3rem !important;
    }

    .text-white span {
        color:#fff !important;
        padding: 0 12px;
        font-size: 16px;
    }

    h3 button span {
        color:#fff !important;
        padding: 0 20px;
        font-size: 20px;
    }

    .report-container {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        margin: 20px auto;
        max-width: 800px;
        /* background-color: #f8f9fa; */
    }
    .report-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .report-header p {
        margin-bottom: .5rem;
    }
    .report-section {
        margin-bottom: 20px;
    }
    .section-title {
        font-weight: bold;
        margin-bottom: 10px;
    }

    

    .display_message{
        background-color: #fff !important;
        color:#111 !important;
    }

    .display_message .email-content
    {
        color:#fff !important;
        font-weight: 400;
    }
    .read_message .email-content,.read_message .email-sender,.read_message .email-subject, .read_message .email-time
    {
        color:#999 !important;
        
    }

    /* ====================================================== */
    .card-header {
        background-color: #c0d0fd;
        font-weight: bold;
        color:#18045e;
    }
    .btn-confirm {
        background-color: #007bff;
        color: white;
    }
    .btn-deny {
        background-color: #dc3545;
        color: white;
    }

    .card-body p {
        margin-bottom:.4rem;
    }

    .card-body {
        background-color: #dce6f1;
    }

    

</style>

<script>
    import { ref } from "vue";
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
                    subject:'',
                    issued_by:'',
                    posting_status:'',
                    participants: [], 
                    priority:"",
                    notification_method:'',
                    location:'',
                    location_link:'',
                    required_action:'',
                    title:'',
                    meeting_type_string:null,
                    meeting_date:null,
                    meeting_time:null,
                    posting_date:null,
                    posting_time:null,
                    first_reminder_date:null,
                    first_reminder_time:null,
                    second_reminder_date:null,
                    second_reminder_time:null,
                    next_meeting_date:null,
                    next_meeting_time:null,
                    checked:false,
                    read:0,
                    type:2,
                    key:'',
                    issued_by_id:'',
                    file_id:'',
                    file_path:'',
                    file_name:'',
                    photo_path:'',
                    is_confirm:0,
                    participant_comments:'',

               }),
               
                user_type:'',
                report_type:0,
                columns:ref( [
                    { title: 'SL', field: 'sl', align: 'center' },
                    { title: 'Issue Date', field: 'meeting' },
                    { title: 'Action', field: 'buttons', sortable: false },
                   
                ]),
                rows: [],
                posting_status_data:[],
                page: 1,
                per_page:15,
                expanded: null
           }
       },
       
       created: function()
       {
           this.fetchMeeting();
       },
       
       methods: {

            newMeeting()
            {
                let route = this.$router.resolve({ path: "/New-Meeting" });
                window.open(route.href,'_self');
                return;

            },
            inboxMeeting()
            {
                this.list_showable=false;
                this.form.reset ();
                this.fetchMeeting();

            },
            sendMeeting()
            {
                let route = this.$router.resolve({ path: "/Sent-Meeting" });
                window.open(route.href,'_self');
                return;

            },
           
            MeetingView(data)
            {
                if(data.value.checked==false)
                {
                    data.value.checked=true;
                    this.list_showable=true;
                    this.form.fill(data.value)

                    if(!data.value.read){
                        this.form.type=2;
                        let uri = '/MeetingStatusChange';
                        this.form.post(uri) .then(({ data }) => { 
                            var response_data=data.split("**");
                                
                            if (response_data[0] * 1 == 1) {
                               
                                console.log("Read")
                                
                            } else if (response_data[0] * 1 == 10) {
                                console.log("Invalid");
                            } else {

                                console.log('Invalid Operation');
                            }                        
                        });
                        data.value.read=1;
                    }
                }
                else{
                    data.value.checked=false;
                    this.list_showable=false;
                    this.form.reset ();
                }
                
            },

            trashMeeting()
            {

                this.form.type=3;
                let uri = '/MeetingStatusChange';
                this.form.post(uri) .then(({ data }) => { 
                    var response_data=data.split("**");
                        
                    if (response_data[0] * 1 == 1) {
                        
                        console.log(this.form.key);
                       // this.rows.splice(this.form.key,1);
                        //delete this.rows[this.form.key][this.form];
                        this.form.reset ();
                        this.list_showable=false;
                        this.fetchMeeting();

                        
                    } else if (response_data[0] * 1 == 10) {
                        console.log("Invalid");
                    } else {

                        console.log('Invalid Operation');
                    }                        
                });
            },

            flagMeeting()
            {

                this.form.type=4;
                let uri = '/MeetingStatusChange';
                this.form.post(uri) .then(({ data }) => { 
                    var response_data=data.split("**");
                        
                    if (response_data[0] * 1 == 1) {

                        this.form.reset ();
                        this.list_showable=false;
                        this.fetchMeeting();
                        
                    } else if (response_data[0] * 1 == 10) {
                        console.log("Invalid");
                    } else {

                        console.log('Invalid Operation');
                    }                        
                });
            },

            blockMeeting()
            {

                this.form.type=5;
                let uri = '/MeetingStatusChange';
                this.form.post(uri) .then(({ data }) => { 
                    var response_data=data.split("**");
                        
                    if (response_data[0] * 1 == 1) {
                        
                        this.form.reset ();
                        this.list_showable=false;
                        this.fetchMeeting();
                        
                    } else if (response_data[0] * 1 == 10) {
                        console.log("Invalid");
                    } else {

                        console.log('Invalid Operation');
                    }                        
                });
            },
            rejectedMeeting()
            {

                this.form.type=6;
                let uri = '/MeetingStatusChange';
                this.form.post(uri) .then(({ data }) => { 
                    var response_data=data.split("**");
                        
                    if (response_data[0] * 1 == 1) {
                        
                        this.form.reset ();
                        this.list_showable=false;
                        this.fetchMeeting();
                        
                    } else if (response_data[0] * 1 == 10) {
                        console.log("Invalid");
                    } else {

                        console.log('Invalid Operation');
                    }                        
                });
            },
            archiveMeeting()
            {

                this.form.type=7;
                let uri = '/MeetingStatusChange';
                this.form.post(uri) .then(({ data }) => { 
                    var response_data=data.split("**");
                        
                    if (response_data[0] * 1 == 1) {
                        
                        this.form.reset ();
                        this.list_showable=false;
                        this.fetchMeeting();
                        
                    } else if (response_data[0] * 1 == 10) {
                        console.log("Invalid");
                    } else {

                        console.log('Invalid Operation');
                    }                        
                });
            },
                       
           
           reset_form()
           {

               this.form.reset ();
               this.editmode=false;
               this.list_showable=false;
               this.fetchMeeting();
               
           },
                      
            fetchMeeting()
            {
                let uri = '/MeetingInbox';
                window.axios.get(uri).then((response) => {
                    this.rows                           =response.data.meeting_send_list;
                   
                }); 
            }, 
            meeting_confirmation(confirmation){

                this.form.is_confirm=confirmation;
                
                this.form.post('/MeetingConfirmation') .then(({ data }) => { 
                   var response_data=data.split("**");
                       
                        if (response_data[0] * 1 == 1) {
                           showToast('Data Save Successfully', 'success');

                           
                               //this.fetchMeeting(response_data[1]);
                              // this.editmode = true;
                           
                           
                           } else if (response_data[0] * 1 == 100) {
                               showToast("Please open the 'Company File' ", 'error');
                       } else {

                           showToast('Invalid Operation', 'error');
                       }      
                   
                })
            } ,           
           
       }
    }  
   
</script>