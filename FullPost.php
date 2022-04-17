<?php require_once "./db/DBOperation.php" ?>
<?php require_once "./include/Session.php" ?>
<?php require_once "./include/Functions.php" ?>
<?php
$admin = 'Thành';
if (isset($_POST['btnAddComment'])) {
    if (empty($_POST['txtUsername']) || empty($_POST['txtEmail']) || empty($_POST['txtComment'])) {
        $_SESSION['errorMessage'] = 'Vui lòng điền đủ thông tin';
    } else {
        $username = $_POST['txtUsername'];
        $email = $_POST['txtEmail'];
        $comment = $_POST['txtComment'];
        $postID = $_GET['id'];

        $db = new DBOperation();
        $db->insertComment(dateTime(), $username, $email, $comment, $admin, 'off', $postID);

        $_SESSION['successMessage'] = 'Đã đăng bình luận';
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/favicon.ico">

    <title>Tin moi</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <link href="css/css/blog.css" rel="stylesheet">
    <style type="text/css">
        .row{
            flex-wrap: nowrap;
        }
        .p-3 {
            /* padding: 100px; */
            margin: 75px 0 0 35px;
        }
    </style>
</head>

<body style="font-family: times-new-roman; font-size: 20px;">

<div class="container pb-3">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                
            </div>
            <div class="col-4 text-center">
                <a class="blog-header-logo text-dark" href="Blog.php?page=1">TIN MOI</a>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <div class="input-group input-group-sm">
                    <form class="form-inline">
                    
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
            <a class="p-2 text-muted" href="Blog.php?page=1">Trang chủ</a>
            <a class="p-2 text-muted" href="Blog.php?page=1&category=Politics">Chính trị</a>
            <a class="p-2 text-muted" href="Blog.php?page=1&category=Business">Kinh doanh</a>
            <a class="p-2 text-muted" href="Blog.php?page=1&category=Science">Khoa học</a>
            <a class="p-2 text-muted" href="Blog.php?page=1&category=Technology">Công nghệ</a>
            <a class="p-2 text-muted" href="Blog.php?page=1&category=Sport">Thể thao</a>
            <a class="p-2 text-muted" href="Blog.php?page=1&category=Health">Sức khỏe</a>
            <a class="p-2 text-muted" href="Blog.php?page=1&category=World">Thế giới</a>
        </nav>
    </div>
</div>

<main role="main" class="container">
    <div class="row">
        <div class="col-md-8 blog-main">
            <div class="blog-post">
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $db = new dbOperation();
                    $finalResult = $db->selectPostFromID($id);

                    $result = $finalResult[0];
                    $rowCount = $finalResult[1];

                    for ($i = 0; $i < $rowCount; $i++) {
                        echo '<h2 class="blog-post-title">' . $result[$i]['title'] . '</h2>';
                        echo '<p class="blog-post-meta">' . $result[$i]['datetime']
                            . '  by <a href="Blog.php?author=' . $result[$i]['author'] . '">' . $result[$i]['author'] . '</a></p>';
                        echo '<hr>';
                        echo '<p>' . $result[$i]['post'] . '</p>';

                    }
                }
                ?>
            </div>

  
            <div class="col-md-8 order-md-1 mw-100 p-0">
                <h4 class="mb-3">Bình luận</h4>
                <div>
                    <?php echo successMessage();
                    echo errorMessage(); ?>
                </div>
                <form class="needs-validation " novalidate method="post"
                      action="FullPost.php?id=<?php echo $_GET['id']; ?>">
                    <div class="mb-3">
                        <label for="username">Userame</label>
                        <input type="text" class="form-control" id="username" placeholder="Username" name="txtUsername">
                        <div class="invalid-feedback">
                            Vui lòng điền tên người dùng
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email" name="txtEmail">
                    </div>
                    <div class="mb-3">
                        <label for="comment">Bình luận</label>
                        <textarea class="form-control" id="comment" name="txtComment" rows="2">

                        </textarea>
                        <div class="invalid-feedback">
                            Vui lòng điền vào trường này
                        </div>
                    </div>
                    <button class="btn btn-success btn-lg btn-block" type="submit" name="btnAddComment">Đăng bình luận</button>
                </form>
            </div>

            <?php
            $db = new dbOperation();
            $finalResult = $db->selectComments('off', $_GET['id']);
            $result = $finalResult[0];
            $rowCount = $finalResult[1];

            for ($i = 0; $i < $rowCount; $i++) {

                echo '<div class="row mt-2 mb-2 pt-3 mr-0 ml-0 img-thumbnail" style="background-color: #f6f7f9">
                        <div class="col-md-2 col-sm-2 hidden-xs">
                            <img class="card-img img-thumbnail" src="http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png" alt="Card image cap">';

                echo '<p class="card-title text-center">' . $result[$i]['name'] . '</p>';
                echo '</div>';

                echo '<div class="card-body col-md-9">';
                echo '<p class="card-text">' . $result[$i]['comment'] . '</p>';
                echo '<p class="card-subtitle text-muted text-right">' . $result[$i]['datetime'] . '</p>';

                echo '</div>
            </div>';
            }
            ?>
        </div>

            <div class="p-3">
                <h4 class="font-italic">Tin gần đây</h4>
                <ol class="list-unstyled mb-0">
                    <?php
                    $db = new dbOperation();
                    $finalResult = $db->selectPost();

                    $result = $finalResult[0];
                    $rowCount = $finalResult[1];
                    if ($rowCount > 8) {
                        $rowCount = 8;
                    }

                    for ($i = 0; $i < $rowCount; $i++) {
                        echo '<li>';
                        echo '- <a href="FullPost.php?id=' . $result[$i]['id'] . '">' . $result[$i]['title'] . '</a>';
                        echo '</li>';
                    }
                    ?>
                </ol>
            </div>
        </aside>

    </div>
</main>
<footer class="blog-footer mt-5">
    <div class="row">
        
    </div>
</footer>
</body>
</html>
