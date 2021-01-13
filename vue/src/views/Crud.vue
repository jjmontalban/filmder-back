<template>
  <v-data-table
    :headers="headers"
    :items="customers"
    :items-per-page="100"
    sort-by="date_add"
    class="elevation-1"
    :footer-props="{
        'showFirstLastPage': true,
        'firstIcon': 'mdi-arrow-collapse-left',
        'lastIcon': 'mdi-arrow-collapse-right',
        'prevIcon': 'mdi-minus',
        'nextIcon': 'mdi-plus',
        'items-per-page-text':'clientes por pagina',
        'items-per-page-all-text':'todos',
        'items-per-page-options':[100,200,500,-1],
      }"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>GB Clientes</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog
          v-model="dialog"
          max-width="800px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >
              Nuevo cliente
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>

                  <v-col cols="12" sm="6" md="6">
                    <v-text-field v-model="editedItem.firstname" label="Nombre"></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="6" md="6">
                    <v-text-field v-model="editedItem.lastname" label="Apellidos"></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="12" md="12">
                    <v-text-field v-model="editedItem.company" label="Empresa"></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="6" md="6">
                    <v-text-field v-model="editedItem.phone1" label="Teléfono"></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="6" md="6">
                    <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="12" md="12">
                    <v-text-field v-model="editedItem.address_1" label="Direccion 1"></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="12" md="12">
                    <v-text-field v-model="editedItem.address_2" label="Direccion 2"></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="6" md="6">
                    <v-text-field v-model="editedItem.address_2" label="Ciudad"></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="6" md="6">
                    <v-text-field v-model="editedItem.state" label="provincia"></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="6" md="6">                  
                    <v-text-field
                      v-model="editedItem.phone_mobile" label="Teléfono 2"></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="6" md="6">
                    <v-text-field v-model="editedItem.cif" label="CIF"></v-text-field>
                  </v-col>
                  
                  <v-col cols="12" sm="6" md="6">                  
                    <v-text-field v-model="editedItem.vat_number" label="VAT Number"></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="6" md="6">
                    <v-text-field v-model="editedItem.country" label="País"></v-text-field>
                  </v-col>

                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="blue darken-1"
                text
                @click="close"
              >
                Cancelar
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click="save"
              >
                Guardar
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="headline">Seguro que quieres eliminar este cliente?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancelar</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
      <v-icon small class="mr-2" @click="deleteItem(item)">mdi-delete</v-icon>
      <v-icon small @click="editItem(item)">mdi-account</v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn
        color="primary"
        @click="initialize"
      >
        Reset
      </v-btn>
    </template>
  </v-data-table>
</template>

<script>
  export default {
    data: () => ({
      config:{
        headers:{
          Authorization: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL3dwLXZ1ZSIsImlhdCI6MTYwOTI1OTg1NiwibmJmIjoxNjA5MjU5ODU2LCJleHAiOjE2MDk4NjQ2NTYsImRhdGEiOnsidXNlciI6eyJpZCI6IjEifX19.ySUodigGco7gxWehU-fgr2r5ACAVT-Rgxu1KTUDZj8s'
        }
      },
      dialog: false,
      dialogDelete: false,
      headers: [
        { text: 'Nombre', value: 'firstname' },
        { text: 'Apellidos', value: 'lastname' },
        { text: 'Empresa', value: 'company' },
        { text: 'Telefono', value: 'telefono_1' },
        { text: 'Email', value: 'email' },
        { text: 'Direccion', value: 'address_1' },
        { text: 'Ciudad', value: 'city' },
        { text: 'Provincia', value: 'state' },
        { text: 'Fecha de registro', value: 'date_add' },
        { text: 'X', value: 'actions', sortable: false },
      ],
      customers: [],
      editedIndex: -1,
      editedItem: {
        firstname: '',
        lastname: '',
        company: '',
        telefono: '',
        email: '',
        direccion: '',
        ciudad: '',
        provincia: '',
      },
      defaultItem: {
        firstname: '',
        lastname: '',
        company: '',
        telefono: '',
        email: '',
        direccion: '',
        ciudad: '',
        provincia: '',
      },
    }),

    computed: {
      formTitle () {
        
        return this.editedIndex === -1 ? 'Nuevo cliente' : ''
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      limpiar(value){
            return value.replace(/<\/?[^>]+(>|$)/g, "")
        },

      async initialize () {
            try {
                //endpoint para customer
                const customersDB = await this.axios.get('v2/customers');                

                await customersDB.data.forEach(element => {
                    let item = {}
                    item.id_customer = element.id_customer;
                    item.firstname = element.firstname;
                    item.lastname = element.lastname;
                    item.email = element.email;
                    item.phone1 = element.phone1;
                    item.phone2 = element.phone2;
                    item.company = element.company;
                    item.shop = element.shop;
                    item.address_1 = element.address_1;
                    item.address_2 = element.address_2;
                    item.postcode = element.postcode;
                    item.city = element.city;
                    item.state = element.state;
                    item.country = element.country;
                    item.postcode = element.vat_number;
                    item.cif = element.cif;
                    item.date_add = item.date_add;

                    this.customers.push(item);
                });

            } catch(error) {
                console.log(error);
            }
        },

      expandItem (item) {
        this.editedIndex = this.customers.indexOf(item)
        this.dialog = true

      },

      editItem (item) {
        this.editedIndex = this.customers.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.customers.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.customers.splice(this.editedIndex, 1)
        this.closeDelete()
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.customers[this.editedIndex], this.editedItem)
        } else {
          const customer = {
            id_customer : this.editedItem.id_customer,
            firstname : this.editedItem.firstname,
            lastname : this.editedItem.lastname,
            email : this.editedItem.email,
            phone1 : this.editedItem.phone1,
            phone2 : this.editedItem.phone2,
            company : this.editedItem.company,
            address_1 : this.editedItem.address_1,
            address_2 : this.editedItem.address_2,
            postcode : this.editedItem.postcode,
            city : this.editedItem.city,
            state : this.editedItem.state,
            country : this.editedItem.country,
            postcode : this.editedItem.vat_number,
            cif : this.editedItem.cif,
          }
            //falta la nueva ruta para el post
//          const customerDB = await this.axios.post('/v2/customers', customer, this.config)

          this.editedItem = 

          this.customers.push(this.editedItem)
        }
        this.close()
      },
    },
  }
</script>