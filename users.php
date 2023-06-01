<?php
require_once "src/auth.php";


$encodedData = $_GET['response'];
$jsonData    = urldecode($encodedData);
$dataArray   = json_decode($jsonData, true);

require_once "src/template/header.php";
?>
    <div class="container">
        <div class="row">
            <h1>Users</h1>
        </div>

        <div class="row">
            <div class="col-lg-12">

            <div id="ajax-message">
                <?php 
                    if(isset( $dataArray )):
                        echo $dataArray['message'];
                    endif;
                ?>
            </div>
            
            <table class="table" id="userListing">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $table = 'users';
                        $sql = "SELECT * from $table";
                        $result = $db->query($sql);
                        $count = 1; 
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $html .= '<tr data-id="'.$row['id'].'">
                                            <td>'.$count.'</td>
                                            <td>'.$row["first_name"].'</td>
                                            <td>'.$row["last_name"].'</td>
                                            <td>'.$row["email"].'</td>
                                            <td>'.ucfirst($row["status"]).'</td>
                                            <td>
                                                <a href="edit-user.php?id='.$row['id'].'" class="btn btn-outline-info btn-sm" title="Edit">
                                                    Edit
                                                </a>
                                                
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteBtn" title="Delete" data-toggle="modal" data-target="#deleteuserModal">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr> ';
                                        $count++;
                            }
                        } else {
                            $html .= '<tr><td colspan="5">No record found.</td></tr>';
                        }
                        mysqli_free_result($result);
                        $db->close();
                        
                        echo $html; 
                    ?>        
                    
                   
                </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Delete Modal-->
    <div class="modal fade" id="deleteuserModal" tabindex="-1" role="dialog" aria-labelledby="Delete"
            aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Delete">Are you sure you want to delete?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Delete" below if you want to delete this record.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="#" name="deleteuserBtn" id="deleteuserBtn" value="">Delete</a>
                </div>
            </div>
        </div>
    </div>

<?php require_once "src/template/footer.php"; ?>