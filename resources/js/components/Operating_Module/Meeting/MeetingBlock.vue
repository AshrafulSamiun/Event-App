<template>
    <fieldset>
           <h4 class="breadcumb"> Meeting/Block</h4>
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
														Meeting Block
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
                                                           
                                                            style="padding:.17rem .15rem"
                                                            @click.prevent="inboxMeeting()">
                                                            <span class="glyphicon glyphicon-inbox"></span>
                                                        </button> 
                                                        <!-- Send -->
                                                        <button  
                                                            title="Send"
                                                            class="btn text-white"
                                                    
                                                            style="padding:.17rem .15rem"
                                                            @click.prevent="sendMeeting()">
                                                            <span class="glyphicon glyphicon-send"></span>
                                                        </button> 

                                
                                                        <button  
                                                            title="Un Block"
                                                            class="btn text-white"
                                                            v-if="form.checked"
                                                            style="padding:.17rem .15rem"
                                                            @click.prevent="unBlockMeeting()">
                                                            <span class="glyphicon glyphicon-ok-sign"></span>
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
													<template #block_date="data">
                                                        <div 
                                                            class="row-card" 
                                                            @click.prevent="MeetingView(data)"
                                                            :class="{'displa_message':data.value.id==form.id}">
                                                            
                                                            <div class="profile-info">
                                                                <img :src="data.value.photo_path" alt="Profile Picture" class="profile-img" />
                                                                <div class="details">
                                                                    <h5>{{ data.value.blocked_user_id }}</h5>
                                                                    <p>{{ data.value.block_user_name }}</p>
                                                                    <p>{{ data.value.user_type }}</p>
                                                                    <p class="status blocked">Blocked</p>
                                                                    
                                                                    <p class="time">{{data.value.block_time}}</p>
                                                                    <p class="time">{{data.value.block_date}}</p>
                                                                </div>
                                                            </div>
                                                            <div class="last-modified">
                                                                <h5>Last Modified Date & Time</h5>
                                                                <p>{{ data.value.block_time }}</p>
                                                                <p>{{ data.value.block_date }}</p>
                                                            </div>
                                                        </div>



                                                        <div 
                                                            class="email-item" 
                                                            @click.prevent="MeetingView(data)" 
                                                            :class="{'displa_message':data.value.id==form.id}" style="display: none;">
                                                            <div class="email-header">
                                                                <div class="d-flex align-items-center">
                                                                    <img style="border-radius:50% ;" :src="data.value.photo_path" alt="Photo" width="40" height="40" />
                                                                    &nbsp;
                                                                    <span class="email-sender">{{ data.value.block_user_name }}</span>
                                                                </div>
                                                                <span class="email-time">{{ data.value.block_time }} &nbsp; {{ data.value.block_date }}</span>
                                                            </div>
                                                            <div class="email-subject">Re:</div>
                                                            <div class="email-content">
                                                                
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
                                                        <p><strong>Issued By:</strong> {{form.issued_by}}</p>
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

    

    .advanced-table table thead {
		display: none !important;
	}


    .row-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px 20px;
        margin: 10px 0;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .profile-info {
        display: flex;
        align-items: center;
    }

    .profile-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 15px;
        object-fit: cover;
    }

    .details {
        font-family: roboto, sans-serif;
        
    }

    .details h5{
        margin: 0;
        font-size: 18px;
        font-weight: 600;  
        font-family: roboto;
        line-height: 20px;
        color:#000000B2;
    }

    .details p {
        margin: 2px 0;
        font-size: 16px;
        font-weight: 500;
        color: #666;
        font-family: roboto;
        line-height: 25px;
    }

    .details .time {
        font-size: 14px;
        font-weight: 500;
        color: #00000080;
        font-family: roboto;
        line-height: 20px;
    }

    .status {
        font-weight: bold;
    }

    .blocked {
        line-height: 40px;
        color:#FF0000B2 !important;
    }

    .last-modified{
        vertical-align: top;
    }

    .last-modified h5{
        text-align: right;
        font-size: 16px;
        color: #666;
        font-weight: 500;
        line-height: 25px;
    }

    .last-modified p{
        text-align: right;
        font-size: 14px;
        font-weight: 500;
        color: #00000080;
        font-family: roboto;
        line-height: 10px;
    }

    /* ======================================= */
    
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
    .displa_message .profile-info,
    .displa_message .details p,
    .displa_message .time p,
    .displa_message .last-modified p,
    .displa_message .last-modified h5
    {
        color:#fff !important;
        
    }

    

</style>

<script>
    import { ref } from "vue";
    import Vue3Datatable from "@bhplugin/vue3-datatable";
    import "@bhplugin/vue3-datatable/dist/style.css";


    export default {
       name:'list-product-categories',
       components:{
            Vue3Datatable,
       },
       data(){
           return{
           
               editmode       :false,
               filter         : '',
              
               list_showable  :false,
               pdf_show_moment:false,
               form:new Form({ 
                    block_user_name:'',                  
                    comments:'', 
                    id:'', 
                    blocked_user_id:'',
                    block_time:'',
                    block_date:'',
                    blocked_user:"",
                    user_type:'',
                    checked:false,
               }),
               
                user_type:'',
                report_type:0,
                columns:ref( [
                    { title: 'SL', field: 'sl', align: 'center' },
                    { title: 'Block Date', field: 'block_date' },
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
           
            MeetingView(data)
            {
                if(data.value.checked==false)
                {
                    data.value.checked=true;
                    this.list_showable=true;
                    this.form.fill(data.value);
                }
                else{
                    data.value.checked=false;
                    this.list_showable=false;
                    this.form.reset ();
                }
                
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

            unBlockMeeting()
            {

                this.form.type=8;
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
                 
           
          
                      
            fetchMeeting()
            {
                let uri = '/MeetingBlock';
                window.axios.get(uri).then((response) => {
                    this.rows                           =response.data.meeting_block_list;
                   
                }); 
            },             
           
       }
    }  
   
</script>