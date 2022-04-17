<?php require_once "./db/DBOperation.php" ?>
<?php require_once "./include/Session.php" ?>
<?php require_once "./include/Functions.php" ?>
<!doctype html>
<html>
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
</head>

<body style="font-family: myriad-pro-light; font-size: 20px;">

<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                
            </div>
            <div class="col-4 text-center">
                <a class="blog-header-logo text-dark" href="Blog.php?page=1">TIN MOI</a>
            </div><!--  d-flex justify-content-end align-items-center  ml-1 -->
            <div class="col-4 clearfix">
                <div class="input-group input-group-sm d-flex flex-row-reverse">
                    <form class="form-inline" method="post">
      
                            <input type="text" class="form-control form-control-sm" placeholder="Tìm kiếm" aria-label="Search" aria-describedby="basic-addon2" name ="txtSearch">
      
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary btn-sm" type="submit" name="search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="mx-3">
                                    <circle cx="10.5" cy="10.5" r="7.5"></circle>
                                    <line x1="21" y1="21" x2="15.8" y2="15.8"></line>
                                </svg>
                            </button>
                        </div>
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

    <div class="row mb-2  pt-5">
        <?php
        $db = new dbOperation();
        if(isset($_GET['page'])){

            $page = $_GET['page'];
            if($page < 1){
                $offset = 0;
            }else{
                // offset = (page - 1) * itemsPerPage + 1;
                $offset = ($page - 1) * 10;
            }

            if (isset($_POST['search'])) {

                $finalResult = $db->selectPostSearch($_POST['txtSearch']);   
                $result = $finalResult[0];
               
                    $title = $result[0]['title'];
                    if (strlen($title) > 38) {
                        $title = substr($title, 0, 38) . '...';
                    }
    
                    $post = $result[0]['post'];
                    if (strlen($post) > 71) {
                        $post = substr($post, 0, 71) . '...';
                    }
    
            } elseif (isset($_GET['category'])) {
                $finalResult = $db->selectPostKey('category', $_GET['category'], $offset);
            } elseif (isset($_GET['author'])) {
                $finalResult = $db->selectPostKey('author', $_GET['author'], $offset);
            } else {
                $finalResult = $db->selectLimitedPost($offset);
            }

            $result = $finalResult[0];
            $rowCount = $finalResult[1];
            
            for ($i = 0; $i < $rowCount; $i++) {
                $title = $result[$i]['title'];

                if (strlen($title) > 38) {
                    $title = substr($title, 0, 38) . '...';
                }

                $post = $result[$i]['post'];
                if (strlen($post) > 71) {
                    $post = substr($post, 0, 71) . '...';
                }

                echo '<div class="col-md-6">
            <div class="card flex-md-row mb-4 shadow-sm h-md-250">
                <div class="card-body d-flex flex-column align-items-start">';


            

                echo '<h3 class="mb-0">'
                    . '<a class="text-dark" href="FullPost.php?id=' . $result[$i]['id'] . '">' . $title
                    . '</a>' . '</h3>';

                echo '<div class="mb-1 text-muted">' . $result[$i]['datetime'] . '</div>';


                echo '<p class="card-text mb-auto">' . $post . '</p>'
                    . '<a href="FullPost.php?id=' . $result[$i]['id'] . '">Đọc tiếp</a>
                </div>'
                    . '<img class="card-img-right flex-auto d-none d-lg-block" src="upload/' . $result[$i]['image'] . '" alt="' . $result[$i]['image'] . '" width="200px" height="250">'
                    . '</div> </div>';

            }



        }else{
            header('Location:' . 'Blog.php?page=1');
        }
        ?>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination  justify-content-center">
            <?php
            if(isset($_GET['page'])){
                $key = '';
                $totalPosts = 0;
                if(isset($_GET['search'])){
                    $totalPosts = $totalPosts + $db->countPosts('search', $_GET['search']);
                    $key = $key . '&search=' . $_GET['search'];
                }
                if (isset($_GET['category'])) {
                    $totalPosts = $totalPosts + $db->countPosts('category', $_GET['category']);
                    $key = $key . '&category=' . $_GET['category'];
                }
                if (isset($_GET['author'])) {
                    $totalPosts = $totalPosts + $db->countPosts('author', $_GET['author']);
                    $key = $key . '&author=' . $_GET['author'];
                }else{
                    $totalPosts = $totalPosts + $db->countPosts('', '');
                    $key = $key . '';
                }

                if($_GET['page'] > 1){
                    echo '<li class="page-item">';
                    echo '<a class="page-link" href="Blog.php?page=' . ($_GET['page'] - 1) . $key .'" aria-label="Previous">';
                    echo '<span aria-hidden="true">&laquo;</span>';
                    echo '<span class="sr-only">Previous</span>';
                    echo '</a>';
                    echo '</li>';
                }
                $db = new dbOperation();
                $postPerPage = ceil($totalPosts/10);

                for($i = 1; $i <= $postPerPage; $i++){
                    if($_GET['page'] == $i){
                        echo '<li class="page-item active">';
                        echo '<a class="page-link" href="Blog.php?page=' . $i . $key .'">';
                        echo $i;
                        echo '</a>';
                        echo '</li>';
                    }else{
                        echo '<li class="page-item">';
                        echo '<a class="page-link" href="Blog.php?page=' . $i . $key . '">';
                        echo $i;
                        echo '</a>';
                        echo '</li>';
                    }
                }

                if($_GET['page'] + 1 <= $postPerPage){
                    echo '<li class="page-item">';
                    echo '<a class="page-link" href="Blog.php?page=' . ($_GET['page'] + 1) . $key . '" aria-label="Next">';
                    echo '<span aria-hidden="true">&raquo;</span>';
                    echo '<span class="sr-only">Next</span>';
                    echo '</a>';
                    echo '</li>';
                }
            }
            ?>
        </ul>
    </nav>
</div>
<footer class="blog-footer">
    <div class="row">
        <div class="col-6 col-md">
            <h5 class="text-dark" style="color: red;">Chuyên mục</h5>
            <ul class="list-unstyled text-small">
                <a class="p-2 text-muted" href="Blog.php?page=1">Trang chủ</a><br>
                <a class="p-2 text-muted" href="Blog.php?page=1&category=Politics">Chính trị</a><br>
                <a class="p-2 text-muted" href="Blog.php?page=1&category=Business">Kinh doanh</a><br>
                <a class="p-2 text-muted" href="Blog.php?page=1&category=Science">Khoa học</a><br>
                <a class="p-2 text-muted" href="Blog.php?page=1&category=Technology">Công nghệ</a><br>
                <a class="p-2 text-muted" href="Blog.php?page=1&category=Sport">Thể thao</a><br>
                <a class="p-2 text-muted" href="Blog.php?page=1&category=Health">Sức khỏe</a><br>
                <a class="p-2 text-muted" href="Blog.php?page=1&category=World">Thế giới</a><br>
            </ul>
        </div>
    </div>
</footer>

</body>
</html>
