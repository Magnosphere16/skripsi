<template>
<div class="container-xl px-4 mt-4">
                <h1 class="page-header-title">
                    <div class="page-header-icon"><i data-feather="user"></i></div>
                    Account Settings
                </h1>
                <!-- <nav class="nav nav-borders">
                    <a class="nav-link ms-0" href="account-profile.html">Profile</a>
                    <a class="nav-link active" href="account-security.html">Security</a>
                </nav> -->
                        <div class="row">
                            <div class="col-xl-4">
                                <!-- Profile picture card-->
                                <div class="card mb-4 mb-xl-0">
                                    <div class="card-header"><strong>Profile Picture</strong></div>
                                    <div class="card-body text-center">
                                        <!-- Profile picture image-->
                                        <img id="userImage" class="img-account-profile rounded-circle mb-2" style="max-width:75%; max-height:75%;" :src="userInfo.userImage" alt="" />
                                        <!-- Profile picture help block-->
                                        <div class="small font-italic text-muted mb-4">JPG no larger than 5 MB</div>
                                        <!-- Profile picture upload button-->
                                        <input type="file" name="upload" id="upload" @change="onFileSelected" style="display:none">
                                        <button class="btn btn-primary" @click="upload_profile" type="button">Upload new image</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <!-- Account details card-->
                                <div class="card mb-4">
                                    <div class="card-header"><strong>Account Details</strong></div>
                                    <div class="card-body">
                                        <form @submit.prevent="editProfile()">
                                            <div class="row gx-3 mb-3">
                                                <div class="col-md-6">
                                                    <label for="name">Name</label>
                                                    <input
                                                        class="form-control"
                                                        id="userName" 
                                                        type="text" 
                                                        v-model="form.userName"
                                                        name="userName" 
                                                        required
                                                        >
                                                        <has-error :form="form" field="userName"></has-error>
                                                </div> 
                                                <div class="col-md-6">
                                                    <label for="qty">Birthdate</label>
                                                        <input v-model="form.userBirthdate" 
                                                            id="userBirthdate" 
                                                            type="date" 
                                                            class="form-control"
                                                            name="userBirthdate"
                                                            required  >
                                                        <has-error :form="form" field="userBirthdate"></has-error>
                                                </div>
                                            </div>
                                            <div class="row gx-3 mb-3">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <label for="name">Email</label>
                                                            <input
                                                                class="form-control"
                                                                id="userEmail" 
                                                                type="text" 
                                                                v-model="form.email"
                                                                name="userEmail" 
                                                                required
                                                                disabled
                                                                >
                                                                <has-error :form="form" field="item_name"></has-error>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <label for="qty">Phone Number</label>
                                                            <input v-model="form.userPhone" 
                                                                id="userPhone" 
                                                                type="text" 
                                                                class="form-control"
                                                                name="userPhone"
                                                                required  >
                                                            <has-error :form="form" field="userPhone"></has-error>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="item_desc">Address</label>
                                                    <textarea v-model="form.userAddress"
                                                        id="userAddress" 
                                                        rows="5" 
                                                        cols="50" 
                                                        class="form-control" 
                                                        name="userAddress" 
                                                        required
                                                        >
                                                    </textarea>
                                                    <has-error :form="form" field="userAddress"></has-error>
                                                </div>
                                            </div>
                                            <div class="row gx-3 mb-3">
                                                <div class="col-md-6">
                                                    <label for="name">Business Name</label>
                                                    <input
                                                        class="form-control"
                                                        id="userBusinessName" 
                                                        type="text" 
                                                        v-model="form.userBusinessName"
                                                        name="userBusinessName" 
                                                        required
                                                        >
                                                        <has-error :form="form" field="userBusinessName"></has-error> 
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="name">Business Category</label>
                                                    <input
                                                        class="form-control"
                                                        id="userBusinesscategory" 
                                                        type="text" 
                                                        v-model="form.userBusinessCategory"
                                                        name="userBusinesscategory" 
                                                        required
                                                        >
                                                        <has-error :form="form" field="userBusinesscategory"></has-error> 
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary btn-md mr-3" style="float:right" :disabled="disabled">
                                                    <i v-show="loading" class="fa fa-spinner fa-spin"></i>
                                                        Save Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
</template>

<script src="http://code.jquery.com/jquery-3.4.1.js"></script>
<script>

</script>

<script>
    export default {
        props: ['userInfo'],
        data(){
            return{
                loading: false,
                disabled: false,
                rand:1,
                form: new Form({    
                    id:"",
                    userName:"",
                    email:"",
                    userAddress:"",
                    userPhone:"",
                    userBirthdate:"",
                    userBusinessName:"",
                    userBusinessCategory:"",
                }),
                formPhoto: new Form({
                    id:"",
                    userImage:"",
                }),
            }
        },
        methods:{
            upload_profile(){
                $("#upload").click();
            },
            onFileSelected(e){
                this.formPhoto.userImage = e.target.files[0];
                var property= e.target.files[0];
                var image_name= property.name;
                var image_extension = image_name.split(".").pop().toLowerCase();

                if (jQuery.inArray(image_extension,['jpg']) != -1){
                    var image_size = property.size;
                    if(image_size <= 5000000){
                            var reader=new FileReader();
                            reader.onload=function(e){
                                $('#userImage').attr('src',e.target.result).css('width','1500px;').css('height','1500px;');
                            };
                            reader.readAsDataURL(e.target.files[0]);
                            //upload photo to database
                            this.formPhoto
                                .post('/api/upload_profile_photo/'+this.formPhoto.id)
                                .then(()=>{
                                Fire.$emit("refreshData");
                                Toast.fire(
                                    'Profile Photo Uploaded Successfully!',
                                    )
                                this.$Progress.finish();
                                this.loading = false;
                                this.disabled = false;
                                })
                    }else{
                        alert("Image maximum size is 5 mb");
                    }
                }else{
                    alert("Invalid Image Extension (must be .jpg)");
                }
            },
            async loadData(){
                this.$Progress.start();
                    this.formPhoto.id=this.userInfo.id;
                    this.form.id=this.userInfo.id;
                    this.form.userName=this.userInfo.userName;
                    this.form.email=this.userInfo.email;
                    this.form.userAddress=this.userInfo.userAddress;
                    this.form.userPhone=this.userInfo.userPhone;
                    this.form.userBirthdate=this.userInfo.userBirthdate;
                    this.form.userBusinessName=this.userInfo.userBusinessName;
                    this.form.userBusinessCategory=this.userInfo.userBusinessCategory;
                this.$Progress.finish();
            },
            editProfile(){
                this.$Progress.start();
                this.loading = true;
                this.disabled = true;

                this.form
                    .post('/api/edit_profile/'+this.form.id)
                    .then(()=>{
                    Fire.$emit("refreshData");
                    Swal.fire(
                        'Success!',
                        'Profile Edited Successfully!',
                        'success'
                        ).then(function() {
                        window.location = "/profile";
                    });
                    this.$Progress.finish();
                    this.loading = false;
                    this.disabled = false;
                    })
                // else
                .catch(()=>{
                    this.$Progress.fail();
                    this.loading = false;
                    this.disabled = false; 
                });
            },
        },
        created(){
            this.loadData();
            Fire.$on('refreshData',() => {
                this.loadData();
            })
        },
    }
</script>
