<?php
  $title="Authors";

  include("includes/init.php");
  $current_page='/';

  $authors=exec_sql_query($db,"SELECT * FROM authors;")->fetchAll();

  $sticky_search="";
  $any_check=False;
  if(isset($_GET['search_submit'])){
    if(!empty($_GET['author_search'])){
      $sticky_search=trim($_GET['author_search']);
    }
    $mystery=(bool)($_GET['mystery']);
    $fantasy=(bool)($_GET['fantasy']);
    $scienceFiction=(bool)($_GET['science-fiction']);
    $nonFiction=(bool)($_GET['non-fiction']);
    $thriller=(bool)($_GET['thriller']);
    $romance=(bool)($_GET['romance']);
    $horror=(bool)($_GET['horror']);
    $other=(bool)($_GET['other']);

    if($mystery || $fantasy || $scienceFiction || $nonFiction || $thriller || $romance || $horror || $other){
      $any_check=True;
      $sticky_mystery=($mystery ? 'checked' : '');
      $sticky_fantasy=($fantasy ? 'checked': '');
      $sticky_scienceFiction=($scienceFiction ? 'checked' : '');
      $sticky_nonFiction=($nonFiction ? 'checked': '');
      $sticky_thriller=($thriller ? 'checked': '');
      $sticky_romance=($romance ? 'checked':  '');
      $sticky_horror=($horror ? 'checked':'');
      $sticky_other=($other ? 'checked' : '');
    }
    if(!empty($_GET['author_search']) || $any_check){
      if(!$any_check){
        $authors=exec_sql_query($db, "SELECT DISTINCT * FROM authors WHERE UPPER(author_name) LIKE UPPER('%' || :search || '%');", array(":search"=>trim($_GET['author_search'])));
      }
      else{
        $filter_expression="";
        if($mystery){
          $filter_expression=$filter_expression . "(tag_author.tag_id=5)";
          $has_filter=True;
        }
        if($fantasy){
          $filter_expression=$filter_expression . ($has_filter ? ' OR ' : '') . "(tag_author.tag_id=1)";
          $has_filter=True;
        }
        if($scienceFiction){
          $filter_expression=$filter_expression . ($has_filter ? ' OR ' : '') . "(tag_author.tag_id=2)";
          $has_filter=True;
        }
        if($thriller){
          $filter_expression=$filter_expression . ($has_filter ? ' OR ' : '') . "(tag_author.tag_id=3)";
          $has_filter=True;
        }
        if($horror){
          $filter_expression=$filter_expression . ($has_filter ? ' OR ' : '') . "(tag_author.tag_id=4)";
          $has_filter=True;
        }
        if($romance){
          $filter_expression=$filter_expression . ($has_filter ? ' OR ' : '') . "(tag_author.tag_id=6)";
          $has_filter=True;
        }
        if($nonFiction){
          $filter_expression=$filter_expression . ($has_filter ? ' OR ' : '') . "(tag_author.tag_id=7)";
          $has_filter=True;
        }
        if($other){
          $filter_expression=$filter_expression . ($has_filter ? 'OR' : '') . "(tag_author.tag_id=8)";
        }
        if(empty($_GET['author_search'])){
          $authors=exec_sql_query($db, "SELECT DISTINCT authors.* from authors INNER JOIN tag_author ON tag_author.author_id=authors.id WHERE " .$filter_expression. ";")->fetchAll();
        }
        else{
          $authors=exec_sql_query($db, "SELECT DISTINCT authors.* from authors INNER JOIN tag_author ON tag_author.author_id=authors.id WHERE (UPPER(authors.author_name) LIKE UPPER('%'||:name||'%')) AND (" .$filter_expression. ");", array(":name"=>$sticky_search))->fetchAll();
        }
      }
    }
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="public/styles/styles.css"/>
  <script type="text/javascript" src="public/scripts/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="public/scripts/effects.js"></script>

  <title><?php echo $title;?></title>
</head>

<body>
  <?php include("includes/header.php");?>

  <section class="banner authors_banner">

    <form action="/" method="GET">
      <h1 class="banner_title">Authors</h1>
      <section class="form_element">
        <input aria-label="author search by name" id="author_search" name="author_search" value="<?php echo htmlspecialchars($sticky_search)?>"/>
        <button type="submit" id="author_search_submit" value="Submit" name='search_submit'>Search</button>
      </section>
      <section class="form_element genres">
        <h3>Genres:</h3>
        <section class="genre_grouping">
          <input type='checkbox' id="mystery" name='mystery' <?php echo $sticky_mystery?>/>
          <label for="mystery">Mystery</label>
        </section>
        <section class="genre_grouping">
          <input type='checkbox' id="fantasy" name='fantasy' <?php echo $sticky_fantasy;?>/>
          <label for='fantasy'>Fantasy</label>
        </section>
        <section class="genre_grouping">
          <input type='checkbox' id="science-fiction" name='science-fiction' <?php echo $sticky_scienceFiction;?>/>
          <label for='science-fiction'>Science-Fiction</label>
        </section>
        <section class="genre_grouping">
          <input type='checkbox' id="thriller" name='thriller' <?php echo $sticky_thriller;?>/>
          <label for='thriller'>Thriller</label>
        </section>
        <section class="genre_grouping">
          <input type='checkbox' id="horror" name='horror' <?php echo $sticky_horror;?>/>
          <label for='horror'>Horror</label>
        </section>
        <section class="genre_grouping">
          <input type='checkbox' id="romance" name='romance' <?php echo $sticky_romance;?>/>
          <label for='romance'>Romance</label>
        </section>
        <section class="genre_grouping">
          <input type='checkbox' id="non-fiction" name='non-fiction' value='non-fiction' <?php echo $sticky_nonFiction;?>/>
          <label for='non-fiction'>Non-Fiction</label>
        </section>
        <section class='genre_grouping'>
          <input type='checkbox' id='other' name='other' value='other' <?php echo $sticky_other;?>/>
          <label for='other'>Other</label>
        </section>
      </section>
    </form>
    <figure>
      <img alt="An author writing in their notebook" src="public/images/authors.jpg"/>
      <figcaption>Source: <a href="https://images.unsplash.com/photo-1579017308347-e53e0d2fc5e9?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=934&q=80">Unsplash</a></figcaption>
      <!-- Source: Unsplash: https://images.unsplash.com/photo-1579017308347-e53e0d2fc5e9?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=934&q=80-->
    </figure>

  </section>

  <main>
    <?php if (count($authors)==0){?>
      <h1>Looks like none of our authors fit your search</h1>
      <h3>Maybe try broadening your search terms or checking the spelling</h3>
    <?php } else{ ?>
    <h1>Check Out Our Amazing Authors</h1>
    <div class="gallery">
      <?php foreach($authors as $author){ ?>
        <a aria-label="<?php echo $author['author_name'];?>" href="/author?id=<?php echo $author['id'];?>">
          <div class="author_gallery_item gallery_item">
            <figure>
              <img alt="author profile picture" src="public/uploads/authors/<?php echo $author['id'] . "." . $author['field'];?>"/>
              <!-- Source: <?php echo $author['pic_source'];?>-->

              <figcaption>Source <a href="<?php echo $author['bio_source'];?>"><?php echo htmlspecialchars($author['author_name']);?></a></figcaption>
            </figure>
            <h3><?php echo $author['author_name'];?></h3>
            <p><?php echo htmlspecialchars($author['bio']). " Source: ("?><a href="<?php echo $author['bio_source'];?>"><?php echo $author['author_name'];?></a>)</p>
          </div>
        </a>

      <?php } ?>
      <div class="gallery_item"></div>
      <div class="gallery_item"></div>
      <?php } ?>



    </div>



  </main>



</body>

</html>
