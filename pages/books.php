<?php
  $title="Books";

  include("includes/init.php");
  $current_page='/books';

  $books=exec_sql_query($db, "SELECT DISTINCT books.id, books.title, books.field, books.pic_source, books.summary_source, books.summary, authors.author_name FROM books LEFT OUTER JOIN authors ON authors.id=books.author_id;")->fetchAll();

  $sticky_search="";
  $any_check=False;
  if(isset($_GET['search_submit'])){
    if(!empty($_GET['book_search'])){
      $sticky_search=trim($_GET['book_search']);
    }
    $mystery=(bool)($_GET['mystery']);
    $fantasy=(bool)($_GET['fantasy']);
    $scienceFiction=(bool)($_GET['science-fiction']);
    $nonFiction=(bool)($_GET['non-fiction']);
    $thriller=(bool)($_GET['thriller']);
    $romance=(bool)($_GET['romance']);
    $horror=(bool)($_GET['horror']);
    $other=(bool)$_GET['other'];

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
    if(!empty($_GET['book_search']) || $any_check){
      if(!$any_check){
        $books=exec_sql_query($db, "SELECT DISTINCT * FROM books WHERE UPPER(title) LIKE UPPER('%' || :search || '%');", array(":search"=>trim($_GET['book_search'])));
      }
      else{
        $filter_expression="";
        if($mystery){
          $filter_expression=$filter_expression . "(tag_book.tag_id=5)";
          $has_filter=True;
        }
        if($fantasy){
          $filter_expression=$filter_expression . ($has_filter ? ' OR ' : '') . "(tag_book.tag_id=1)";
          $has_filter=True;
        }
        if($scienceFiction){
          $filter_expression=$filter_expression . ($has_filter ? ' OR ' : '') . "(tag_book.tag_id=2)";
          $has_filter=True;
        }
        if($thriller){
          $filter_expression=$filter_expression . ($has_filter ? ' OR ' : '') . "(tag_book.tag_id=3)";
          $has_filter=True;
        }
        if($horror){
          $filter_expression=$filter_expression . ($has_filter ? ' OR ' : '') . "(tag_book.tag_id=4)";
          $has_filter=True;
        }
        if($romance){
          $filter_expression=$filter_expression . ($has_filter ? ' OR ' : '') . "(tag_book.tag_id=6)";
          $has_filter=True;
        }
        if($nonFiction){
          $filter_expression=$filter_expression . ($has_filter ? ' OR ' : '') . "(tag_book.tag_id=7)";
          $has_filter=True;
        }
        if($other){
          $filter_expression=$filter_expression . ($has_filter ? ' OR ' : '') . "(tag_book.id=8)";
        }
        if(empty($_GET['book_search'])){
          $books=exec_sql_query($db, "SELECT DISTINCT books.* from books INNER JOIN tag_book ON tag_book.book_id=books.id WHERE " .$filter_expression. ";")->fetchAll();
        }
        else{
          $books=exec_sql_query($db, "SELECT DISTINCT books.* from books INNER JOIN tag_book ON tag_book.book_id=books.id WHERE (UPPER(books.title) LIKE UPPER('%'||:name||'%')) AND (" .$filter_expression. ");", array(":name"=>$sticky_search))->fetchAll();
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

  <section class="banner books_banner">

    <form action="/books" method="GET">
      <h1 class="banner_title">Books</h1>
      <section class="form_element">
        <input aria-label='search for a book' id="book_search" name="book_search" value="<?php echo $sticky_search;?>"/>
        <button type="submit" id="book_search_submit"  value="Submit" name='search_submit'>Search</button>
      </section>
      <section class="form_element genres">
        <h3>Genres:</h3>
        <section class="genre_grouping">
          <input type='checkbox' id="mystery" name='mystery' value='mystery' <?php echo $sticky_mystery;?>/>
          <label for="mystery">Mystery</label>
        </section>
        <section class="genre_grouping">
          <input type='checkbox' id="fantasy" name='fantasy' value='fantasy' <?php echo $sticky_fantasy;?>/>
          <label for='fantasy'>Fantasy</label>
        </section>
        <section class="genre_grouping">
          <input type='checkbox' id="science-fiction" name='science-fiction' value='science-fiction' <?php echo $sticky_scienceFiction;?>/>
          <label for='science-fiction'>Science-Fiction</label>
        </section>
        <section class="genre_grouping">
          <input type='checkbox' id="thriller" name='thriller' value='thriller' <?php echo $sticky_thriller;?>/>
          <label for='thriller'>Thriller</label>
        </section>
        <section class="genre_grouping">
          <input type='checkbox' id="horror" name='horror' value='horror' <?php echo $sticky_horror;?>/>
          <label for='horror'>Horror</label>
        </section>
        <section class="genre_grouping">
          <input type='checkbox' id="romance" name='romance' value='romance' <?php echo $sticky_romance;?>/>
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
      <img alt="Books in a library" src="public/images/books.jpg"/>
      <figcaption>Source: <a href="https://images.unsplash.com/photo-1532012197267-da84d127e765?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=934&q=80">Unsplash</a></figcaption>
      <!-- Source: Unsplash: https://images.unsplash.com/photo-1532012197267-da84d127e765?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=934&q=80-->
    </figure>

  </section>

  <main>
    <?php if (count($books)==0){?>
      <h1>Looks like none of our books fit your search</h1>
      <h3>Maybe try broadening your search terms or checking the spelling</h3>
    <?php } else{?>
    <h1>Book Catalog</h1>
    <div class="gallery">
      <?php foreach($books as $book){?>
      <a aria-label='<?php echo htmlspecialchars($book['title']);?>' href="/book?id=<?php echo $book['id'];?>">
        <div class="book_gallery_item gallery_item">
          <figure>
            <img alt="book cover picture" src="public/uploads/books/<?php echo $book['id'] . "." . htmlspecialchars($book['field']);?>"/>
            <!-- Source: <?php echo htmlspecialchars($book['pic_source']);?> -->

            <figcaption>Source <a href="<?php echo $book['summary_source'];?>"><?php echo $book['title'];?></a></figcaption>
          </figure>
          <h3><?php echo $book['title'];?></h3>
          <?php
            if (strlen($book['summary'])>200){
              $first_chunk=substr(htmlspecialchars($book['summary']), 0, strpos(htmlspecialchars($book['summary']), ' ', 200));
              $second_chunk=substr(htmlspecialchars($book['summary']), strpos(htmlspecialchars($book['summary']), ' ', 200));
              ?>

              <p><?php echo $first_chunk;?><button class="read_more" id="<?php echo $book['id'];?>_expander">...Read More</button><span class="more hidden" id="<?php echo $book['id'];?>_more"><?php echo $second_chunk . " Source: (";?><a href="<?php echo $book['summary_source'];?>"><?php echo $book['title'];?></a>)<button class="read_less" id="<?php echo $book['id'];?>_hider">...Read Less</button></span></p>
            <?php }
            else{?>
              <p><?php echo $book['summary'] . " Source: ("?><a href="<?php echo $book['summary_source'];?>"><?php echo $book['title'];?></a></p>
            <?php } ?>


        </div>
        </a>
      <?php } ?>
      <div class="gallery_item"></div>
      <div class="gallery_item"></div>
    </div>
    <?php } ?>

  </main>



</body>

</html>
