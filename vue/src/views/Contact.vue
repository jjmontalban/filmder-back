<template>
    <v-row class="text-center">
        <v-col cols="12">
            <h1 class="display-2 font-weight-bold mb-3">This is an contact page.</h1>
        </v-col>
    </v-row>
</template>

<script>
  export default {
    data: () => ({
      config:{
        headers:{
          
        }
      },
      dialog: false,
      dialogDelete: false,
      headers: [
        
      ],
      customers: [],
      editedIndex: -1,
      editedItem: {
        id_customer: '',
        firstname: '',
        lastname: '',
        company: '',
        phone_1: '',
        phone_2: '',
        address_1: '',
        address_2: '',
        postcode: '',
        city: '',
        state: '',
        country: '',
        shop: '',
        cif: '',
        vat_number: '',
        date_add: '',
      },
      defaultItem: {
        id_customer: '',
        firstname: '',
        lastname: '',
        company: '',
        phone_1: '',
        phone_2: '',
        address_1: '',
        address_2: '',
        postcode: '',
        city: '',
        state: '',
        country: '',
        shop: '',
        cif: '',
        vat_number: '',
        date_add: '',
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
                    item.phone_1 = element.phone_1;
                    item.phone_2 = element.phone_2;
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
                    item.vat_number = element.vat_number;
                    item.date_add = element.date_add;
                    this.customers.push(item);
                });
            } catch(error) {
                console.log(error);
            }
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
      async save () {
        if (this.editedIndex > -1) { //ejecuta edicion
          Object.assign(this.customers[this.editedIndex], this.editedItem)
        } else { //ejecuta creacion
          
            try{
              const customer = {
                id : this.editedItem.id,
                firstname : this.editedItem.firstname,
                lastname : this.editedItem.lastname,
                company : this.editedItem.company,
                email : this.editedItem.email,
                phone_1 : this.editedItem.phone_1,
                phone_2 : this.editedItem.phone_2,
                address_1 : this.editedItem.address_1,
                address_2 : this.editedItem.address_2,
                shop : this.editedItem.shop,
                postcode : this.editedItem.postcode,
                city : this.editedItem.city,
                state : this.editedItem.state,
                country : this.editedItem.country,
                vat_number : this.editedItem.vat_number,
                cif : this.editedItem.cif,
                date_add : this.editedItem.date_add,
                }  
              //falta la nueva ruta para el post
              const customerDB = await this.axios.post('/v2/customer', customer, this.config)
            console.log(customerDB.data);
            this.customers.push(this.editedItem)
            }catch(error){
              console.log(error);
            }
          
        }
        this.close()
      },
    },
  }
</script>