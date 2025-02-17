<template>
    <fieldset>
           <h4 class="breadcumb"> Announcement/Sent</h4>
           <p class="breadcumb-p">Operation Modules/Administrative/Announcement</p>

           
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
														Announcement Sent
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
                                                            @click.prevent="newAnnouncement()">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </button> 

                                                        <!-- Inbox -->
                                                        <button 
                                                            title="Inbox" 
                                                            class="btn text-white"
                                                            :class="{'text-white':form.checked==true}"
                                                            style="padding:.17rem .15rem"
                                                            @click.prevent="inboxAnnouncement()">
                                                            <span class="glyphicon glyphicon-inbox"></span>
                                                        </button> 
                                                        <!-- Send -->
                                                        <button  
                                                            title="Send"
                                                            class="btn text-white"
                                                            :class="{'text-white':form.checked==true}"
                                                            style="padding:.17rem .15rem"
                                                            @click.prevent="sendAnnouncement()">
                                                            <span class="glyphicon glyphicon-send"></span>
                                                        </button> 

                                                        <button 
                                                            title="Trash" 
                                                            class="btn text-white"
                                                            v-if="form.checked"
                                                            style="padding:.17rem .25rem"
                                                            @click.prevent="trashAnnouncement()">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </button>

                                                        <button 
                                                            title="Flag" 
                                                            class="btn text-white"
                                                            v-if="form.checked"
                                                            style="padding:.17rem .25rem"
                                                            @click.prevent="flagAnnouncement()">
                                                            <span class="glyphicon glyphicon-flag"></span>
                                                        </button>

                                                        <button  
                                                            title="Block"
                                                            class="btn text-white"
                                                            v-if="form.checked"
                                                            style="padding:.17rem .15rem"
                                                            @click.prevent="blockAnnouncement()">
                                                            <span class="glyphicon glyphicon-ban-circle"></span>
                                                        </button> 
                                                        <button  
                                                            title="Rejectd"
                                                            class="btn text-white"
                                                            v-if="form.checked"
                                                            style="padding:.17rem .25rem"
                                                            @click.prevent="rejectedAnnouncement()">
                                                            <span class="glyphicon glyphicon-remove-circle"></span>
                                                        </button>
                                                        <button 
                                                            title="Archive" 
                                                            class="btn text-white"
                                                            v-if="form.checked"
                                                            style="padding:.17rem .15rem"
                                                            @click.prevent="archiveAnnouncement()">
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
												
												<vue3-datatable :rows="rows" :columns="columns" :search="filter" :sortable="true" rowClass="cursor-pointer" class="advanced-table whitespace-nowrap">
													<template #sl="data">	
                                                       												
                                                        <button 
                                                            v-if="data.value.checked" 
                                                            class="btn "
                                                            style="padding:.17rem .25rem"
                                                            @click.prevent="AnnouncementView(data)">
                                                            <span class="glyphicon glyphicon-check"></span>
                                                        </button>
                                                        <button  
                                                            v-else 
                                                            class="btn "
                                                            style="padding:.17rem .15rem"
                                                            @click.prevent="AnnouncementView(data)">
                                                            <span class="glyphicon glyphicon-unchecked"></span>
                                                        </button> 
													</template>
													<template #announcement="data">
                                                        <div 
                                                            class="email-item" 
                                                            @click.prevent="AnnouncementView(data)" 
                                                            :class="{'displa_message':data.value.system_no==form.system_no,'read_message':data.value.read && data.value.system_no!=form.system_no}">
                                                            <div class="email-header">
                                                                <div class="d-flex align-items-center">
                                                                    <img style="border-radius:50% ;" :src="data.value.photo_path" alt="Photo" width="40" height="40" />
                                                                    &nbsp;
                                                                    <span class="email-sender">{{ data.value.announcement.issued_by }}</span>
                                                                </div>
                                                                <span class="email-time">{{ data.value.announcement.posting_time }} &nbsp; {{ data.value.announcement.posting_date }}</span>
                                                            </div>
                                                            <div class="email-subject">Re: {{ data.value.announcement.subject }}</div>
                                                            <div class="email-content">
                                                                {{ data.value.announcement.required_action }}....
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
											<div class="container">
                                                <div class="report-container">
                                                    <div class="report-header">
                                                        <div>
                                                            <p><strong>No:</strong> {{form.system_no}}</p>
                                                            <p><strong>Date:</strong> {{form.issue_date}}</p>
                                                            <p><strong>Time:</strong> {{form.issue_time}}</p>
                                                            <p><strong>Issued To:</strong> {{form.issue_to}}</p>
                                                            <p><strong>Participants:</strong> {{form.participants}}</p>
                                                            <p><strong>Priority:</strong> High</p>
                                                        </div>
                                                        
                                                    </div>

                                                    <div class="report-section">
                                                        <p><strong>SUBJECT:</strong> {{form.subject}}</p>
                                                    </div>
                                                    <div class="report-section">
                                                        <p class="section-title">Required Action</p>
                                                        <p>{{form.required_action}}</p>
                                                    </div>
                                                    <div class="report-section">
                                                        <p class="section-title">Instruction</p>
                                                        <p>{{form.instruction}}</p>
                                                    </div>
                                                    <div class="report-section">
                                                        <p class="section-title">Financial</p>
                                                        <p>{{form.financial}}</p>
                                                    </div>
                                                    <div class="report-section">
                                                        <p class="section-title">Safety Tips</p>
                                                        <p>{{form.safety_tips}}</p>
                                                    </div>
                                                    <div class="report-section">
                                                        <p class="section-title">Comment</p>
                                                        <p>{{form.comments}}</p>
                                                    </div>
                                                    <div class="text-end">
                                                        <p><strong>Issued By:</strong>
                                                           
                                                            {{form.issued_by}}
                                                            &nbsp;
                                                            <img style="border-radius:50% ;" :src="form.photo_path" alt="Photo" width="40" height="40" />

                                                        </p>
                                                    </div>
                                                    <div class="text-end" v-if="form.file_path">
                                                        <p><strong>Attatchment:</strong>
                                                           
                                                            <span>{{ form.file_name }}</span>&nbsp;
                                                        
                                                        <button  type="button">
                                                            <a :href="form.file_path"  target="_new">Download</a>
                                                        </button>
                                                        </p>
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
        background-color: #f8f9fa;
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
        background-color: #f8f9fa;
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

    .displa_message{
        background-color: #2e86f8 !important;
        color:#fff !important
    }

    .displa_message .email-content
    {
        color:#fff !important;
        font-weight: 400;
    }
    .read_message .email-content,.read_message .email-sender,.read_message .email-subject, .read_message .email-time
    {
        color:#999 !important;
        
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
                    issue_to:[],
                    participants: [], 
                    priority:"",
                    location:'',
                    required_action:'',
                    instruction:'',
                    financial:'',
                    safety_tips:'',
                    issue_date:null,
                    issue_time:null,
                    formated_issue_time:'',
                    checked:false,
                    read:0,
                    type:2,
                    key:'',
                    issued_by_id:'',
                    file_id:'',
                    file_path:'',
                    file_name:'',
                    photo_path:'',
               }),
               
                user_type:'',
                report_type:0,
                columns:ref( [
                    { title: 'SL', field: 'sl', align: 'center' },
                    { title: 'Issue Date', field: 'announcement' },
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
           this.fetchAnnouncement();
       },
       
       methods: {

            newAnnouncement()
            {
                let route = this.$router.resolve({ path: "/New-Announcement" });
                window.open(route.href,'_self');
                return;

            },
            inboxAnnouncement()
            {
                let route = this.$router.resolve({ path: "/Inbox-Announcement" });
                window.open(route.href,'_self');
                return;

            },
            sendAnnouncement()
            {
                this.list_showable=false;
                this.form.reset ();
                this.fetchAnnouncement();

            },
           
            AnnouncementView(data)
            {
                if(data.value.checked==false)
                {
                    data.value.checked=true;
                    this.list_showable=true;
                    this.form.fill(data.value)

                    if(!data.value.read){
                        this.form.type=2;
                        let uri = '/AnnouncementStatusChange';
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

            trashAnnouncement()
            {

                this.form.type=3;
                let uri = '/AnnouncementStatusChange';
                this.form.post(uri) .then(({ data }) => { 
                    var response_data=data.split("**");
                        
                    if (response_data[0] * 1 == 1) {
                        
                        console.log(this.form.key);
                       // this.rows.splice(this.form.key,1);
                        //delete this.rows[this.form.key][this.form];
                        this.form.reset ();
                        this.list_showable=false;
                        this.fetchAnnouncement();

                        
                    } else if (response_data[0] * 1 == 10) {
                        console.log("Invalid");
                    } else {

                        console.log('Invalid Operation');
                    }                        
                });
            },

            flagAnnouncement()
            {

                this.form.type=4;
                let uri = '/AnnouncementStatusChange';
                this.form.post(uri) .then(({ data }) => { 
                    var response_data=data.split("**");
                        
                    if (response_data[0] * 1 == 1) {

                        this.form.reset ();
                        this.list_showable=false;
                        this.fetchAnnouncement();
                        
                    } else if (response_data[0] * 1 == 10) {
                        console.log("Invalid");
                    } else {

                        console.log('Invalid Operation');
                    }                        
                });
            },

            blockAnnouncement()
            {

                this.form.type=5;
                let uri = '/AnnouncementStatusChange';
                this.form.post(uri) .then(({ data }) => { 
                    var response_data=data.split("**");
                        
                    if (response_data[0] * 1 == 1) {
                        
                        this.form.reset ();
                        this.list_showable=false;
                        this.fetchAnnouncement();
                        
                    } else if (response_data[0] * 1 == 10) {
                        console.log("Invalid");
                    } else {

                        console.log('Invalid Operation');
                    }                        
                });
            },
            rejectedAnnouncement()
            {

                this.form.type=6;
                let uri = '/AnnouncementStatusChange';
                this.form.post(uri) .then(({ data }) => { 
                    var response_data=data.split("**");
                        
                    if (response_data[0] * 1 == 1) {
                        
                        this.form.reset ();
                        this.list_showable=false;
                        this.fetchAnnouncement();
                        
                    } else if (response_data[0] * 1 == 10) {
                        console.log("Invalid");
                    } else {

                        console.log('Invalid Operation');
                    }                        
                });
            },
            archiveAnnouncement()
            {

                this.form.type=7;
                let uri = '/AnnouncementStatusChange';
                this.form.post(uri) .then(({ data }) => { 
                    var response_data=data.split("**");
                        
                    if (response_data[0] * 1 == 1) {
                        
                        this.form.reset ();
                        this.list_showable=false;
                        this.fetchAnnouncement();
                        
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
               this.fetchAnnouncement();
               
           },
                      
            fetchAnnouncement()
            {
                let uri = '/AnnouncementSent';
                window.axios.get(uri).then((response) => {
                    this.rows                           =response.data.announcement_send_list;
                   
                }); 
            },             
           
       }
    }  
   
</script>