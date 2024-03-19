<script setup>

    import axios, { isCancel } from "axios";

    import { ref, onMounted, reactive } from "vue";

    import { Form , Field} from 'vee-validate';

    import * as yup from 'yup';

    const users = ref([]);

    // edit a user
    const editing = ref(false);

    const formValues = ref();

    // for editing form
    const form = ref(null);
    

    // const form = reactive({

    //     name: '',

    //     email : '',

    //     password: '',
    // });


    const getUsers = () => {
        axios.get('/api/users')

        .then((response) => {
            users.value = response.data;
        })
    }


    const createUserSchema = yup.object({
        name: yup.string().required(),
        email: yup.string().email().required(),
        password: yup.string().required().min(8),


    });

    const editUserSchema = yup.object({
        name: yup.string().required(),
        email: yup.string().email().required(),
        password: yup.string().when((password, schema) => {
        return password ? schema.required().min(8) : schema;
        }),
    });


    const createUser = (values, { resetForm }) => {

        // console.log(values);

        axios.post('/api/users', values)
        .then((response) => {
            users.value.unshift(response.data);
            
            $('#userFormModal').modal('hide');
            resetForm();
        });
    }




    const addUser = () => {
        editing.value = false;
        $('#userFormModal').modal('show');

    }


    const editUser = (user) => {

        console.log(user);

        editing.value = true;
        $('#userFormModal').modal('show');

        form.value.resetForm();

        // formValues.value = user;

        formValues.value = {

            id: user.id,
            name: user.name,
            email: user.email,
            // password: user.password,

        };
    };


    
    const updateUser = (values, { setErrors }) => {
        axios.put('/api/users/' + formValues.value.id, values)
            .then((response) => {
                const index = users.value.data.findIndex(user => user.id === response.data.id);
                users.value.data[index] = response.data;
                $('#userFormModal').modal('hide');
                toastr.success('User updated successfully!');
            }).catch((error) => {
                setErrors(error.response.data.errors);
                console.log(error);
            });
    }

    const handleSubmit = (values, actions) => {
        // console.log(actions);
        if (editing.value) {
            updateUser(values, actions);
        } else {
            createUser(values, actions);
        }
    }

    // now let,s to call the getUsers() method:
   onMounted( () => {
        getUsers();
   })





    // const createUser = () => {

    //     axios.post('/api/users', form)
    //     .then((response) => {
    //         users.value.unshift(response.data);
    //         form.name = '',
    //         form.email = '',
    //         form.password = '';
    //         $('#userFormModal').modal('hide');
    //     });

    // }



   

 

   
</script>

<template>
    
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1><br>
                    <button @click="addUser" type="button" class="btn btn-primary">
                        Add New User
                    </button>
                </div>
                
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Users  list</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <!-- <div class="content"> -->
        <!-- <div class="container-fluid"> -->
            <table class="table table-bordered">
                <thead>
                    <th>ID</th>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Register date</th>

                    <th>Role</th>

                    <th>Options</th>
                </thead>
                <tbody>

                    <tr v-for="(user, index) in users" :key="user.id">

                        <td>{{ index + 1 }}</td>

                        <td>{{ user.name }}</td>

                        <td>{{ user.email }}</td>

                        <td>-</td>

                        <td>-</td>

                        <td>
                            <a href="#" @click.prevent="editUser(user)"><i class="fa fa-edit"></i></a>
                        </td>


                    </tr>

                </tbody>
            </table>
            <!-- Modal -->

            <div class="modal fade" id="userFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                <span v-if="editing">Edit User</span>
                                <span v-else>Add New User</span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <Form ref="form" @submit="handleSubmit" :validation-schema=" editing? editUserSchema : createUserSchema" v-slot="{ errors }" :initial-values="formValues">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Name</label>
                                <Field name="name" type="text" class="form-control"  :class="{'is-invalid':errors.name}" id="recipient-name"/>
                                <span>{{ errors.name }}</span>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Email</label>
                                <Field name="email" type="text" class="form-control" :class="{'is-invalid':errors.email}" id="recipient-name"/>
                                <span>{{ errors.email }}</span>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Password</label>
                                <Field name="password" type="text" class="form-control" :class="{'is-invalid':errors.password}" id="recipient-name"/>
                                <span>{{ errors.password }}</span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </Form>
                </div>
            </div>  <!-- modal -->
        </div>   <!-- // container-fluid -->
    <!-- </div>  // content -->

</template>