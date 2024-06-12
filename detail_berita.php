<?php 
    session_start();
    include('includes/config.php');
    if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
        }
    if(isset($_POST['submit'])){
        if (!empty($_POST['csrftoken'])) {
            if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
                $name=$_POST['name'];
                $email=$_POST['email'];
                $comment=$_POST['comment'];
                $postid=intval($_GET['nid']);
                $st1='0';
                $query=mysqli_query($con,"insert into tblcomments(postId,name,email,comment,status) values('$postid','$name','$email','$comment','$st1')");
                if($query):
                    echo "<script>alert('comment successfully submit. Comment will be display after admin review ');</script>";
                    unset($_SESSION['token']);
                    else :
                        echo "<script>alert('Something went wrong. Please try again.');</script>";  
                    endif;
                }
            }
        }
        $postid=intval($_GET['nid']);
        $sql = "SELECT viewCounter FROM tblposts WHERE id = '$postid'";
        $result = $con->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $visits = $row["viewCounter"];
                $sql = "UPDATE tblposts SET viewCounter = $visits+1 WHERE id ='$postid'";
                $con->query($sql);
            }
        } else {
            echo "no results";
        }
?>

<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Kanal Berita</title>
<body>

    <?php 
        include('includes/header.php');
    ?>

    <div class="container-fluid align-items-center">
        <div class="row" style="margin-top: 4%">
            <div class="col-md-9 mt-5">
                <?php
                    $pid=intval($_GET['nid']);
                    $currenturl="http://".$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];;
                    $query=mysqli_query($con,"select tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url,tblposts.postedBy,tblposts.lastUpdatedBy,tblposts.UpdationDate from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.id='$pid'");
                    while ($row=mysqli_fetch_array($query)) {
                ?>
                <div class="card border-0">
                    <div class="card-body">
                        <a class="badge bg-success text-decoration-none link-light" href="category.php?catid=<?php echo htmlentities($row['cid'])?>" style="color:#fff"><?php echo htmlentities($row['category']);?></a>
                        <a class="badge bg-warning text-decoration-none link-light" style="color:#fff"><?php echo htmlentities($row['subcategory']);?></a>
                        <h1 class="card-title"><?php echo htmlentities($row['posttitle']);?></h1>

                        <p>
                            by <?php echo htmlentities($row['postedBy']);?> on | <?php echo htmlentities($row['postingdate']);?>
                            <?php if($row['lastUpdatedBy']!=''):?>
                            Last Updated by <?php echo htmlentities($row['lastUpdatedBy']);?> on<?php echo htmlentities($row['UpdationDate']);?>
                        </p>
                        <?php endif;?>
                        <p>
                            <b>Visits:</b> <?php print $visits; ?>
                        </p>
                        <hr>
                        <img class="img-fluid w-100" src="admin/postimages/<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>">
                        <p class="card-text"><?php $pt=$row['postdetails']; echo  (substr($pt,0));?></p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-8">
            <?php 
                $sts=1;
                $query=mysqli_query($con,"select name,comment,postingDate from  tblcomments where postId='$pid' and status='$sts'");
                while ($row=mysqli_fetch_array($query)) {
            ?>
            <div class="media mb-4">
                <img class="d-flex mr-3 rounded-circle" src="images/usericon.png" alt="">
                <div class="media-body">
                    <h5 class="mt-0"><?php echo htmlentities($row['name']);?> <br />
                        <span style="font-size:11px;"><b>at</b> <?php echo htmlentities($row['postingDate']);?></span>
                    </h5>
                    <?php echo htmlentities($row['comment']);?>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="col-md-8">
            <hr>
            <div class="card my-4 bg-transparent border-0">
                <h5 class="card-header bg-transparent border-0">Leave a Comment</h5>
                <div class="card-body">
                    <form name="Comment" method="post">
                        <input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />
                        <div class="form-group">
                            <input type="text" name="name" class="form-control rounded-0" placeholder="Enter your fullname" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control rounded-0" placeholder="Enter your Valid email" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <textarea class="form-control rounded-0" name="comment" rows="3" placeholder="Comment" required></textarea>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-danger" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php 
        include('includes/footer.php');
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>