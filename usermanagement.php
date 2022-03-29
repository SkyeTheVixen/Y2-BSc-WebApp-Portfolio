<?php
    $currentPage="usermanagement";
    $title="User Management | VD Training";
    $pathHead="res/";
    $pageRedirect="";
    include("res/php/_connect.php");
    include("res/php/_authcheck.php");
    
    include("res/php/main/header.php"); 
    include("res/php/main/navbar.php");
?>


<!-- Main Content -->
<div class="container">
    <!-- Table of Users -->
    <div class="row mt-5">
        <table class="mt-5 table table-striped table-hover" id="userTable">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Job Title</th>
                    <th>Access Level</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM `tblUsers`";
                    $run = mysqli_query($mysqli, $sql);
                    while($result = mysqli_fetch_assoc($run))
                    {
                ?>
                    <tr>
                        <td><?=$result["FirstName"]?></td>
                        <td><?=$result["LastName"]?></td>
                        <td><?=$result["Email"]?></td>
                        <td><?=$result["JobTitle"]?></td>
                        <td><?=$result["AccessLevel"]?></td>
                        <td><a class="editUUID" data-id="<?=$result["UUID"]?>"><i class="fa fa-pencil"></i></a>
                        </td>
                        <td><a class="delUUID" data-id="<?=$result["UUID"]?>"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php
                        }
                    ?>
            </tbody>
        </table>
        <!-- End Table of Users -->
    </div>

    <button class="px-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>

    <form id="TogglePassReset">
        <?php
            $allowReset = file_get_contents("res/php/data.txt");
            if($allowReset == "true")
            {
                echo "<input class=\"form-check-input\" type=\"checkbox\" checked role=\"switch\" id=\"userPassReset\" name=\"userPassReset\">";
            }
            else
            {
                echo "<input class=\"form-check-input\" type=\"checkbox\" role=\"switch\" id=\"userPassReset\" name=\"userPassReset\" checked>";
            }

        ?>
        <label for="togglePassReset">Allow Password Reset</label>
    </form>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addUserForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addFirstName" class="form-label">First Name</label>
                            <input type="text" required class="form-control" name="addFirstName">
                        </div>
                        <div class="mb-3">
                            <label for="addLastName" class="form-label">Last Name</label>
                            <input type="text" required class="form-control" name="addLastName">
                        </div>
                        <div class="mb-3">
                            <label for="addJobTitle" class="form-label">Job Title</label>
                            <input type="text" required class="form-control" name="addJobTitle">
                        </div>
                        <div class="mb-3">
                            <label for="addAccessLevel" class="form-label">Access Level</label>
                            <select class="form-select" required name="addAccessLevel" aria-label="selectAccessLevel">
                                <option selected>Access Level</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addEmail" class="form-label">Email address</label>
                            <input type="email" required class="form-control" name="addEmail">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="addUserBtn">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Add User Modal -->

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editUserForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="firstNameInput" class="form-label">First Name</label>
                            <input type="text" required class="form-control" name="editFirstName" id="editFirstName">
                        </div>
                        <div class="mb-3">
                            <label for="lastNameInput" class="form-label">Last Name</label>
                            <input type="text" required class="form-control" id="editLastName" name="editLastName">
                        </div>
                        <div class="mb-3">
                            <label for="jobTitleInput" class="form-label">Job Title</label>
                            <input type="text" required class="form-control" name="editJobTitle" id="editJobTitle">
                        </div>
                        <div class="mb-3">
                            <label for="accessLevelSelect" class="form-label">Access Level</label>
                            <select class="form-select" required name="editAccessLevel" id="editAccessLevel" aria-label="selectAccessLevel">
                                <option selected>Access Level</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email address</label>
                            <input type="email" required class="form-control" name="editEmail" id="editEmail">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="editUUID" id="editUUID">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="editUserBtn">Edit User</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End Edit User Modal -->
</div>
<!-- End Main Content -->


<?php
    include("res/php/main/main.footer.php");
?>