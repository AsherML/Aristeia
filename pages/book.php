<?php
  $title="Book";



  //get the book from the url id
  $book_id=(int)trim($_GET['id']);
  $current_page="/book?id=".$book_id;
  include("includes/init.php");

  define("MAX_FILE_SIZE", 1000000);

  $edit_mode=False;
  $edit_authorization=False;



  //get the book on this page
  $records=exec_sql_query($db, "SELECT books.*, authors.author_name FROM books INNER JOIN authors ON books.author_id=authors.id WHERE books.id=:id;", array(':id' => $book_id))->fetchAll();
  if(count($records)>0){
    $book=$records[0];
    $current_user=current_user();
    if(is_user_logged_in() && $current_user['id']==$book['author_id']){
      $edit_authorization=True;
    }

    $books_by_author=exec_sql_query($db, "SELECT * FROM books WHERE author_id=:id;", array(':id'=>$book['author_id']))->fetchAll();

    if(is_user_logged_in()){
      /*Please note that I'm not algorithmically searching here.
        PHP duplicates values for sql queries, such that when I want
         my results to be [id1, id2, etc...] it returns [[0=>id1,
          "id"=>id1], [[0=>id2, "id"=>id2], etc...]] The below code
          simply cleans this to a one dimensional array, no searching
          is taking place.
        */
      $actual_ids=array();
      $actual_ids[0]="filler";
      $liked_books_ids=exec_sql_query($db, "SELECT books.id FROM books INNER JOIN author_book_likes ON author_book_likes.book_id=books.id WHERE author_book_likes.author_id=:id;", array(":id"=>current_user()['id']))->fetchAll();
      for($i=0; $i<count($liked_books_ids); $i++){
          $actual_ids[$i+1]=$liked_books_ids[$i]['id'];
      }
    }

    $genres=exec_sql_query($db, "SELECT tag_book.tag_id, tags.tag  FROM tag_book INNER JOIN tags ON tag_book.tag_id=tags.id WHERE book_id=:id", array(':id'=>$book_id))->fetchAll();

    $genre_words=array();
    $similar_books=array();
    foreach($genres as $genre){
      /*
      I spoke with my TA in office hours and they said that even
      though this isn't a single SQL query, it's the best way to accomplish my task.
      Any book might have any one of the 8 tags, which means that the only way I'd be able to search for all books with my variable-length
      set of tags would be to pass in an array as an sql parameter.
      However, the function provided doesn't allow for this.
      As such, my only recourse was to do a separate SQL query for each
      genre's books
      */
      array_push($genre_words, $genre['tag']);
      $this_genre=exec_sql_query($db, "SELECT books.*, authors.author_name FROM books INNER JOIN authors ON authors.id=books.author_id INNER JOIN tag_book ON tag_book.book_id=books.id WHERE books.id!=:book_id AND tag_book.tag_id=:id", array(':book_id'=>$book_id, ":id"=>$genre['tag_id']))->fetchAll();
      $similar_books=array_merge($similar_books, $this_genre);
    }

    $similar_authors=exec_sql_query($db, "SELECT authors.* FROM authors INNER JOIN author_author ON authors.id=author_author.second_author_id WHERE author_author.first_author_id=:id;", array(":id"=>$book['author_id']))->fetchAll();
  }
  else{
    $book=Null;
  }

  if(isset($_GET['edit'])){
    $edit_mode=True;
    $sticky_all_genres=array();
    $sticky_all_genres[0]="filler";
    $dump=exec_sql_query($db, "SELECT tag from tags INNER JOIN tag_book ON tags.id=tag_book.tag_id WHERE tag_book.book_id=:book_id;", array(":book_id"=>$book['id']))->fetchAll();
    for ($i=0;$i<count($dump); $i++){
      array_push($sticky_all_genres, $dump[$i]['tag']);
    }
    $sticky_mystery_edit=(array_search('Mystery', $sticky_all_genres) ? "checked" : '');
    $sticky_fantasy_edit=(array_search("Fantasy", $sticky_all_genres) ? "checked" : "");
    $sticky_science_fiction_edit=(array_search("Science-Fiction", $sticky_all_genres) ? "checked" : "");
    $sticky_thriller_edit=(array_search("Thriller", $sticky_all_genres) ? "checked" : "");
    $sticky_horror_edit=(array_search("Horror", $sticky_all_genres) ? "checked" : "");
    $sticky_romance_edit=(array_search("Romance", $sticky_all_genres) ? "checked" : "");
    $sticky_non_fiction_edit=(array_search("Non-Fiction", $sticky_all_genres) ? "checked" : "");
    $sticky_other_edit=(array_search("Other", $sticky_all_genres) ? "checked" : "");
  }

  //delete the book
  if(is_user_logged_in() && $current_user['id']==$author['id'] && isset($_POST['book_delete'])){
    $to_delete=$_POST['to_delete'];
    exec_sql_query($db, "DELETE FROM books WHERE id=:to_delete", array(":to_delete"=>$to_delete));
    $books_by_author=exec_sql_query($db, "SELECT * FROM books WHERE author_id=:id;", array(':id'=>$author['id']))->fetchAll();
  }
  //like a book
  $already_liked=False;
  $already_disliked=True;
  if(is_user_logged_in() && isset($_POST['book_like'])){
    if(!array_search($_POST['book_like_id'], $actual_ids)){
      exec_sql_query($db, "INSERT INTO author_book_likes (author_id, book_id) VALUES (:author_id, :book_id);", array(':author_id'=>current_user()['id'], ':book_id'=>trim($_POST['book_like_id'])));
      $liked_books=exec_sql_query($db, "SELECT books.*, authors.author_name FROM books INNER JOIN authors ON authors.id=books.author_id INNER JOIN author_book_likes ON author_book_likes.book_id=books.id WHERE author_book_likes.author_id=:id;", array(":id"=>$author_id))->fetchAll();
      $already_liked=True;
      $already_disliked=False;
    }
  }

  //unlike a book

  if(is_user_logged_in() && isset($_POST['book_unlike'])){
    if(array_search($_POST['book_unlike_id'], $actual_ids)){
      exec_sql_query($db, "DELETE FROM author_book_likes WHERE author_id=:author_id AND book_id=:book_id", array(":author_id"=>current_user()['id'], ":book_id"=>$_POST['book_unlike_id']));
      $liked_books=exec_sql_query($db, "SELECT books.*, authors.author_name FROM books INNER JOIN authors ON authors.id=books.author_id INNER JOIN author_book_likes ON author_book_likes.book_id=books.id WHERE author_book_likes.author_id=:id;", array(":id"=>$author_id))->fetchAll();
      $already_liked=False;
      $already_disliked=True;
      unset($actual_ids[array_search($_POST['book_unlike_id'],$actual_ids)]);
    }
  }

  //adding similarities
  $existing=exec_sql_query($db, "SELECT * FROM author_author WHERE first_author_id=:first_author AND second_author_id=:second_author", array(":first_author"=>$current_user['id'], ":second_author"=>$author['id']))->fetchAll();
  $already_similar=count($existing)>0 || $current_user['id']==$author['id'];
  if(is_user_logged_in() && isset($_POST['add_similarity'])){
    if(!$already_similar){
      exec_sql_query($db, "INSERT INTO author_author (first_author_id, second_author_id) VALUES (:first_one, :second_one);", array(":first_one"=>$current_user['id'], ':second_one'=>trim($_POST['second_author'])));
      $existing=exec_sql_query($db, "SELECT * FROM author_author WHERE first_author_id=:first_author AND second_author_id=:second_author", array(":first_author"=>$current_user['id'], ":second_author"=>$author['id']))->fetchAll();
      $already_similar=count($existing)>0 || $current_user['id']==$author['id'];
    }
    $similar_authors=exec_sql_query($db, "SELECT authors.* FROM authors INNER JOIN author_author ON authors.id=author_author.second_author_id WHERE author_author.first_author_id=:id;", array(":id"=>$author_id))->fetchAll();
  }
  if(is_user_logged_in() && isset($_POST['remove_similarity'])){
    if($already_similar){
      exec_sql_query($db, "DELETE FROM author_author WHERE first_author_id=:first_author AND second_author_id=:second_author", array(":first_author"=>current_user()['id'], ':second_user'=>$_POST['second_author_id']));
    }
  }


  //edit the book
  $sticky_title=$book['title'];
  $sticky_summary=$book['summary'];
  $sticky_pic_source=$book['pic_source'];
  $sticky_summary_source=$book['summary_source'];
  $image_error='hidden';
  if (isset($_POST['submit_book_edit'])){
    if(!is_null($_POST['edit_title'])){
      $sticky_title=trim($_POST['edit_title']);
    }

    if(!is_null($_POST['edit_summary'])){
      $sticky_summary=trim($_POST['edit_summary']);
    }

    if(!is_null($_POST['edit_pic_source'])){
      $sticky_pic_source=trim($_POST['edit_pic_source']);
    }

    if(!is_null($_POST['edit_summary_source'])){
      $sticky_summary_source=trim($_POST['edit_summary_source']);
    }

    if (isset($_POST['mystery']) && $sticky_mystery_edit!="checked"){
      exec_sql_query($db, "INSERT INTO tag_book (tag_id, book_id) VALUES (5, :book_id);", array(":book_id"=>$book['id']));
    }

    if(isset($_POST['fantasy']) && $sticky_fantasy_edit!="checked"){
      exec_sql_query($db, "INSERT INTO tag_book (tag_id, book_id) VALUES (1, :book_id);", array(":book_id"=>$book['id']));
    }

    if(isset($_POST['science-fiction']) && $sticky_science_fiction_edit!='checked'){
      exec_sql_query($db, "INSERT INTO tag_book (tag_id, book_id) VALUES (2, :book_id);", array(":book_id"=>$book['id']));
    }

    if(isset($_POST['thriller']) && $sticky_thriller_edit!='checked'){
      exec_sql_query($db, "INSERT INTO tag_book (tag_id, book_id) VALUES (3, :book_id);", array(":book_id"=>$book['id']));
    }

    if(isset($_POST['horror']) && $sticky_horror_edit!='checked'){
      exec_sql_query($db, "INSERT INTO tag_book (tag_id, book_id) VALUES (4, :book_id);", array(":book_id"=>$book['id']));
    }

    if(isset($_POST['romance']) && $sticky_romance_edit!='checked'){
      exec_sql_query($db, "INSERT INTO tag_book (tag_id, book_id) VALUES (6, :book_id);", array(":book_id"=>$book['id']));
    }

    if(isset($_POST['non-fiction']) && $sticky_non_fiction_edit!='checked'){
      exec_sql_query($db, "INSERT INTO tag_book (tag_id, book_id) VALUES (7, :book_id);", array(":book_id"=>$book['id']));
    }
    if(isset($_POST['other']) && $sticky_other_edit!='checked'){
      exec_sql_query($db, "INSERT INTO tag_book (tag_id, book_id) VALUES (8, :book_id);", array(":book_id"=>$book['id']));
    }

    $new_pic=$_FILES['edit_picture'];


    if ($sticky_title!=$book['title'] || trim($sticky_summary)!=$book['summary'] || $sticky_pic_source!=$book['pic_source'] || $sticky_summary_source!=$book['summary_source'] || !is_null($new_pic)){

      if($new_pic['name']==''){
        $db->beginTransaction();
        exec_sql_query($db, "UPDATE books SET title=:title, summary=:summary, pic_source=:pic_source, summary_source=:summary_source WHERE id=:id;",array(":title"=>$sticky_title, ':summary'=>$sticky_summary, ':pic_source'=>$sticky_pic_source, ':summary_source'=>$sticky_summary_source, ':id'=>$book['id']));
        $book=exec_sql_query($db, "SELECT books.*, authors.author_name FROM books INNER JOIN authors ON books.author_id=authors.id WHERE books.id=:id;", array(':id' => $book_id))->fetchAll()[0];
        $db->commit();
      }
      else{
        $upload_valid=False;
        if(($new_pic['error']==UPLOAD_ERR_OK || $new_pic['error']==0) && $new_pic['size']<MAX_FILE_SIZE){

          $upload_valid=True;
          $new_filename=basename($new_pic['name']);
          $new_ext=strtolower(pathinfo($new_filename, PATHINFO_EXTENSION));
          if($new_ext!='svg' && $new_ext!="jpg" && $new_ext!='png' && $new_ext!='jpeg'){
            $upload_valid=False;
          }
        }
        if($upload_valid){
          unlink("public/uploads/books/".$book['id']. '.' . $book['field']);

          $db->beginTransaction();
          exec_sql_query($db, "UPDATE books SET title=:title, summary=:summary, pic_source=:pic_source, summary_source=:summary_source, field=:field WHERE id=:id;",array(":title"=>$sticky_title, ':summary'=>$sticky_summary, ':pic_source'=>$sticky_pic_source, ':summary_source'=>$sticky_summary_source, ':field'=>$new_ext));
          $new_path="public/uploads/books/".$book['id'].'.'.$new_ext;
          move_uploaded_file($new_pic['tmp_name'], $new_path);
          $db->commit();
        }
        else{
          $image_error='';
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
  <?php if(is_null($book)){ ?>
    <section class="banner book_banner">

      <section class="description">
        <p class="breadcrumbs"><a href="/books">Books</a> > Book Not Found</p>
        <h1>Oops...Book Not Found</h1>
        <p>It looks like the book you're looking for no longer exists. It could have been deleted, the link you're following might be broken, or maybe the great planeswalkers that wander the cybersphere have simply decided that this page does not deserve to be. Please return to the main catalog to continue exploring our amazing books and authors.</p>
      </section>
      <figure>
        <img alt="picture of a maze" src="public/images/maze.jpg"/>
        <figcaption>Source: <a href="https://images.unsplash.com/photo-1590278458425-6aa3912a48a5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2249&q=80">Unsplash</a></figcaption>
        <!-- Source: https://images.unsplash.com/photo-1590278458425-6aa3912a48a5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2249&q=80-->
      </figure>
    </section>

  <?php } else {?>
  <section class="banner book_banner">
      <section class="description">
        <p class="breadcrumbs"><a href="/books">Books</a> > <a href="/books?id=<?php echo $book_id;?>"><?php echo htmlspecialchars($book['title']);?></a></p>
        <?php if ($edit_mode && $edit_authorization) {?>
          <form class="edit_book" enctype='multipart/form-data' id='edit_book' action="<?php echo $current_page;?>" method="POST" novalidate>
            <section class="form_element">
              <label for="edit_title">Title:</label>
              <input type="text" id="edit_title" name="edit_title" value="<?php echo htmlspecialchars($book['title']);?>">
            </section>
            <section class="form_element">
              <label for="edit_summary">Summary:</label>
              <textarea cols=50 rows=15 id="edit_summary" name="edit_summary"><?php echo htmlspecialchars($book['summary']);?></textarea>
            </section>
            <section class="form_element">
              <label for='edit_summary_source'>Summary Source (Optional):</label>
              <input type='text' name='edit_summary_source' id='edit_summary_source' value="<?php echo htmlspecialchars($book['summary_source']);?>">
            </section>
            <section class="form_element">
              <label for='edit_pic_source'>Picture Source (Optional):</label>
              <input type='text' name='edit_pic_source' id='edit_pic_source' value='<?php echo htmlspecialchars($book['pic_source']);?>'>
            </section>

            <h2>Genres:</h2>
            <section class="form_element genres">
              <section class="genre_grouping">
                <input type='checkbox' id="mystery" name='mystery' <?php echo $sticky_mystery_edit?>/>
                <label for="mystery">Mystery</label>
              </section>
              <section class="genre_grouping">
                <input type='checkbox' id="fantasy" name='fantasy' <?php echo $sticky_fantasy_edit;?>/>
                <label for='fantasy'>Fantasy</label>
              </section>
              <section class="genre_grouping">
                <input type='checkbox' id="science-fiction" name='science-fiction' <?php echo $sticky_science_fiction_edit;?>/>
                <label for='science-fiction'>Science-Fiction</label>
              </section>
              <section class="genre_grouping">
                <input type='checkbox' id="thriller" name='thriller' <?php echo $sticky_thriller_edit;?>/>
                <label for='thriller'>Thriller</label>
              </section>
              <section class="genre_grouping">
                <input type='checkbox' id="horror" name='horror' <?php echo $sticky_horror_edit;?>/>
                <label for='horror'>Horror</label>
              </section>
              <section class="genre_grouping">
                <input type='checkbox' id="romance" name='romance' <?php echo $sticky_romance_edit;?>/>
                <label for='romance'>Romance</label>
              </section>
              <section class="genre_grouping">
                <input type='checkbox' id="non-fiction" name='non-fiction' value='non-fiction' <?php echo $sticky_non_fiction_edit;?>/>
                <label for='non-fiction'>Non-Fiction</label>
              </section>
              <section class='genre_grouping'>
                <input type='checkbox' id='other' name='other' value='other' <?php echo $sticky_other_edit;?>/>
                <label for='other'>Other</label>
              </section>
            </section>
          </form>
        <?php } else { ?>
          <h1><?php echo htmlspecialchars($book['title']);?></h1>
          <ul class="genre_description">
            <?php foreach ($genre_words as $genre) {?>
              <li><?php echo $genre;?></li>
            <?php } ?>
          </ul>
          <p><?php echo htmlspecialchars($book['summary']);?></p>
          <?php if($edit_authorization){?>
            <div class="row">
              <form action="<?php echo $current_page;?>" method="POST">
                <button class="book_delete" type='submit' name='book_delete'>Delete Book</button>
                <input type='hidden' name='to_delete' value="<?php echo $book['id'];?>"/>
              </form>
              <a href="<?php echo $current_page . "&edit=True"?>" class="edit_button_banner">Edit Entry</a>
            </div>
          <?php } ?>
        <?php } ?>

        </section>
        <figure>
          <?php if ($edit_mode && $edit_authorization){?>
            <div class="banner_container">
              <img class="darken" alt="cover of the book" src="public/uploads/books/<?php echo $book['id'] . '.' . $book['field'];?>"/>
              <input form='edit_book' name='edit_picture' type="file" id="edit_picture" accept=".png,.jpeg,.svg,.jpg">
              <input type="hidden" form='edit_book' name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
            </div>
          <?php } else{ ?>
            <img  alt="cover of the book" src="public/uploads/books/<?php echo $book['id'] . '.' . $book['field'];?>"/>
          <?php } ?>
          <figcaption>
            Source: <a href="<?php echo $book['pic_source'];?>"><?php echo htmlspecialchars($book['title']);?></a>
            <!-- Source: <?php echo $book['pic_source'];?>-->
          </figcaption>
          <?php if(is_user_logged_in()){?>
            <?php if($current_user['id'] == $book['author_id']) {?>
              <button type="submit" class="book_like disabled" id="book_like<?php echo $book['id']?>">Like</button>
            <?php } else if (array_search($book['id'], $actual_ids) || $already_liked){?>
              <form class='banner_like_form' action=<?php echo $current_page?> method="POST">
                <input type="hidden" name='book_unlike_id' value=<?php echo $book['id'];?>>
                <button type='submit' name='book_unlike' class="book_like" id="book_unlike">Un-Like</button>
                </form>
            <?php } else{ ?>
              <form class='banner_like_form' action=<?php echo $current_page?> method="POST">
                <input type="hidden" name='book_like_id' value=<?php echo $book['id'];?>>
                <button type='submit' name='book_like' class="book_like" id="book_like<?php echo $book['id']?>">Like</button>
                </form>
          <?php } }?>
        </figure>
  </section>
  <?php if ($edit_authorization && $edit_mode){?>
    <button type='submit' form='edit_book' id='submit_book_edit' name='submit_book_edit'>Submit</button>
  <?php } } ?>
  <section class="books_by">
    <h1>Books By <?php echo htmlspecialchars($book['author_name']);?></h1>
        <ul class="entries">
          <?php foreach($books_by_author as $book){
            include("includes/book_entry.php");
          }?>
        </ul>
  </section>
  <section class="similar_books">
      <h1>Similar Books</h1>
        <ul class="entries">
          <?php foreach($similar_books as $book){
            include("includes/book_entry.php");
          }?>
        </ul>
  </section>
  <section class="similar_authors">
      <h1>Similar Authors</h1>
        <ul class="entries">
          <?php foreach($similar_authors as $author){
            include("includes/author_entry.php");
          }?>
        </ul>
  </section>
  <section class="popup <?php echo $image_error?>">
    <section class='popup_header'>
      <h1>Error</h1>
      <button id="close_popup">&times;</button>
    </section>
    <h1>Something went wrong trying to upload your new picture. Please try again or use a different picture</h1>
  </section>
</body>
</html>
