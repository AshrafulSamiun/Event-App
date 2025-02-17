<template>

  <fieldset>
    <form id="msform" @submit.prevent="editmode ? updateCompanyProfile() : createCompanyProfile()"
          @keydown="form.onKeydown($event)">
      <div class="form-card">
        <div class="form-folder">
          <h3><i class="fa fa-hand-point-right"></i> Open File:</h3>
          <div class="form-holder">
            <div class="row align-self-stretch">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-box-outer">
                  <div class="pull-left" style="margin-top:50px;">
                    <label for="filter" class="sr-only">Filter</label>
                    <input type="text" class="form-control" v-model="filter" placeholder="Filter" style="width:400px;">
                  </div>
                  <vue3-datatable :rows="form.company_arr" :columns="columns" :columnFilter="true" :sortable="true" rowClass="cursor-pointer" @rowClick="change_company"> </vue3-datatable>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </fieldset>
</template>

<script>
  import { ref } from "vue";
  import Vue3Datatable from "@bhplugin/vue3-datatable";
  import "@bhplugin/vue3-datatable/dist/style.css";

  import DatePicker from 'vue3-datepicker';

  export default {
    name: 'list-product-categories',
    components: {
      DatePicker,
      Vue3Datatable
    },
    data() {
      return {
        editmode: false,
        show_company: true,
        filter: '',
        form: new Form({

          company_avaibale: true,
          company_id: "",
          company_type: '',
          account_no: '',
          legal_name: '',
          currency_id: '',
          company_arr: [],
        }),

        columns: ref([
          {title: 'SL', field: 'sl', align: 'center'},
          {title: 'Company', field: 'company_name'},
          {title: 'Last Modified Date and Time', field: 'last_modified_date'},
          {title: 'Last Modification By', field: 'last_modified_by'},
        ]),
        page: 1,
        per_page: 15,
        expanded: null
      }
    },

    created: function () {

      this.user_menu_name = this.$route.name;
      this.fetchOpenFile();

    },

    methods: {

      change_company(row) {
          this.form.company_avaibale  =true,
          this.form.company_id 		=row.company_id,
          this.form.company_name		=row.company_name,
          this.form.last_modified_by  =row.last_modified_by,
          this.form.last_modified_date=row.last_modified_date,
          this.form.post('/OpenFiles').then(({data}) => {
            window.open('/Dashboard', '_self');
          })
      },


      fetchOpenFile() {
        let uri = '/OpenFiles';
        window.axios.get(uri).then((response) => {
          this.form.company_avaibale = response.data.company_avaibale;
          this.form.company_id = response.data.company_id;
          this.form.company_type = response.data.company_type;
          this.form.account_no = response.data.account_no;
          this.form.legal_name = response.data.legal_name;
          this.form.currency_id = response.data.currency_id;
          this.form.company_arr = response.data.company_arr;

        });
      },

    }

  }

</script>