<?php require_once "./db/DBOperation.php" ?>
<?php require_once "./include/Session.php" ?>
<?php require_once "./include/Functions.php" ?>
<?php confirmLogin(); ?>
<?php
$admin = 'Thành';
if (isset($_POST['btnAddPost'])) {
    if (empty($_POST['txtTitle']) || empty($_POST['category']) || empty($_FILES['image']) || empty($_POST['txtPost'])) {
        $_SESSION['errorMessage'] = 'Please fill all the fields';
    } else {
        $title = $_POST['txtTitle'];
        $category = $_POST['category'];

        $imageName = $_FILES['image']['name'];
        $image = $_FILES['image']['tmp_name'];

        $post = nl2br($_POST['txtPost']);

        $db = new DBOperation();
        $db->insertPost($title, dateTime(), $category, $admin, $imageName, $image, $post);

        $_SESSION['successMessage'] = 'Đã thêm bài viết';
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

    <title>Thêm bài viết</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="css/css/starter-template.css" rel="stylesheet">
    <link href="css/css/dashboard.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="Blog.php?page=1">Tin tức</a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="SignOut.php">Đăng xuất</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="Dashboard.php">
                            <span data-feather="home"></span>
                            Quản lí <span class="sr-only">(hiện tại)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="AddNewPost.php">
                            <span data-feather="file"></span>
                            Thêm bài viết
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Categories.php">
                            <span data-feather="shopping-cart"></span>
                            Chuyên mục <span class="sr-only">(hiện tại)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Admins.php">
                            <span data-feather="users"></span>
                            Admin
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Comments.php">
                            <span data-feather="bar-chart-2"></span>
                            Bình luận
                        </a>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>------------------------------- </span>
                    <a class="d-flex align-items-center text-muted" href="#">
                        <span data-feather="plus-circle"></span>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="Blog.php?page=1">
                            <span data-feather="file-text"></span>
                            Đi tới trang web
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 pt-lg-0">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h1 class="h2">Thêm bài viết</h1>
            </div>

            <div>
                <?php echo successMessage();
                echo errorMessage();
                ?>
            </div>

            <div class="col-md-8 order-md-1 mw-100 p-0">
                <form class="needs-validation " novalidate method="post" action="AddNewPost.php"
                      enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title">Tiêu đề</label>
                        <input type="text" class="form-control" id="title" placeholder="Tiêu đề" name="txtTitle">
                    </div>
                    <div class="mb-3">
                        <label for="category">Chuyên mục</label>
                        <select class="custom-select d-block w-100" id="category" name="category" required>
                            <?php
                            $db = new dbOperation();
                            $finalResult = $db->selectCategory();

                            $result = $finalResult[0];
                            $rowCount = $finalResult[1];

                            for ($i = 0; $i < $rowCount; $i++) {
                                echo '<option>' . $result[$i]['category'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image"  name="image">
                            <label class="custom-file-label" for="image">Tải hình ảnh</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="post">Nội dung</label>
                        <textarea class="form-control" id="post" placeholder="Nội dung" name="txtPost"
                                  rows="2"></textarea>
                    </div>
                    <button class="btn btn-success btn-lg btn-block" type="submit" name="btnAddPost">Thêm bài viết</button>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>