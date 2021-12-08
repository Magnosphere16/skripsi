<template>
<!-- body structure -->
    <div class="container">
                <div class="Background" style="background-color: #33E2FF; left:0;">
                    <form enctype="multipart/form-data" id="update_profile_photo">
                        <!-- @csrf -->
                        <div class="row justify-content-center">
                            <img class="photo-img mt-5" id="image-user" style="width:150px; height:150px; border-radius: 100%;" src="https://assets.pikiran-rakyat.com/crop/0x0:0x0/x/photo/2021/05/18/1067981407.jpg">
                        </div>
                        <div class="row justify-content-center mb-5">
                            <label class="change_photo" for="img_upload_id" id="submitPhoto" style="color:white;">Change Photo</label>
                        </div>
                        <div class="row justify-content-center">
                            <p id="photoSubmit" style="display:none;">
                                <button type="button" id="uploadBtn" class="btn btn-primary">
                                    Submit photo
                                </button>
                                <button type="button" class="btn btn-danger" id="photoCancel">
                                    Cancel
                                </button>
                            </p>
                        </div>
                    </form>
                </div>
                <div class="main_profile">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card_section">
                                <div class="card">
                                    <div class="card-body">

                                    <h2>Basic Profiles <a id="basic_btn">
                                                <!-- <img src="/images/edit.png" alt="edit_button" style="max-width:2.5%;"> -->
                                            </a></h2>
                                    <div id="basic_content">          
                                        <form enctype="multipart/form-data" id="update_basic_data">
                                            <!-- @csrf -->
                                            <div class="row">
                                                <div class="col">
                                                    <strong>Username</strong>
                                                    <p>{{this.userInfo.userName}}</p>
                                                    <span id="error_name"></span>
                                                </div>
                                                <div class="col">
                                                    <strong>Birthdate</strong>
                                                    <p>{{this.userInfo.userBirthdate}}</p>
                                                    <span id="error_birthdate"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <strong>Email</strong>
                                                    <p>{{this.userInfo.email}}</p>
                                                </div>
                                                <div class="col">
                                                    <strong>Address</strong>
                                                    <span id="error_address"></span>
                                                    <p>{{this.userInfo.userAddress}}</p>
                                                </div>
                                            </div>
                                            <div class="row" id="submitBtn" style="display:none;">
                                                <div class="col-md-8">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" id="editBasic" data-target="#basicConfirmation">
                                                            Submit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" id="basicCancel">
                                                            Cancel
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="basicConfirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header text-center">
                                                            <h4 class="modal-title" id="exampleModalLongTitle">Change Basic Information</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to change your basic information?</p>
                                                            <button id="basicEditBtn" type="button"  class="btn btn-primary" data-dismiss="modal" aria-label="Close">
                                                                Submit
                                                            </button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <br>

                                    <h2>Business <a id="education_btn">
                                            <!-- <img src="/images/edit.png" alt="educ_btn" style="max-width:2.5%;"> -->
                                        </a>
                                    </h2>
                                    <div id="education_content">
                                        <form enctype="multipart/form-data" id="update_education_data">
                                         <!-- @csrf -->
                                        <div class="row">
                                            <div class="col">
                                                <strong>Business Name</strong>
                                                <p>{{this.userInfo.userBusinessName}}</p>
                                                <span id="error_educ_level"></span>
                                            </div>
                                            <div class="col">
                                                <strong>Business Category</strong>
                                                <p>{{this.userInfo.userBusinessCategory}}</p>
                                                <span id="error_grade"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <strong>Warehouse Capacity</strong>
                                                <p>0</p>
                                                <span id="error_school"></span>
                                            </div>
                                        </div>
                                        <div class="row" id="btn_submit" style="display:none;">
                                            <div class="col-md-8">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" id="editEduc" data-target="#educationConfirmation">
                                                            Submit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" id="educationCancel">
                                                            Cancel
                                                    </button>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="educationConfirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header text-center">
                                                        <h4 class="modal-title" id="exampleModalLongTitle">Change Business Information</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to change your Business information?</p>
                                                        <button id="educEditBtn" type="button"  class="btn btn-primary" data-dismiss="modal" aria-label="Close">
                                                            Submit
                                                        </button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
        mounted() {
            console.log(this.userInfo);
        }
    }
</script>
