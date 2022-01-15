<?php
  $title="Author";

  include("includes/init.php");
  define("MAX_FILE_SIZE", 1000000);

  $author_id=(int)trim($_GET['id']);
  $current_page="/author?id=".$author_id;
  $show_popup="hidden";
  $edit_authorization=False;
  $edit_mode=False;

  //check to see if the url is valid
  if(isset($_GET['id'])){
    $potential_author=exec_sql_query($db, "SELECT * FROM authors WHERE id=:id;", array(":id"=>$author_id))->fetchAll();
    if(count($potential_author)>0){
      $author=$potential_author[0];
      if(is_user_logged_in() && $current_user['id']==$book['author_id']){
        $edit_authorization=True;
      }
    }
    else{
      $author=Null;
    }
  }
  if($author){
    if(is_user_logged_in() && $current_user['id']==$author_id){
      $edit_authorization=True;
    }
    $books_by_author=exec_sql_query($db, "SELECT * FROM books WHERE author_id=:id;", array(':id'=>$author['id']))->fetchAll();

    $similar_authors=exec_sql_query($db, "SELECT authors.* FROM authors INNER JOIN author_author ON authors.id=author_author.second_author_id WHERE author_author.first_author_id=:id;", array(":id"=>$author_id))->fetchAll();

    $liked_books=exec_sql_query($db, "SELECT books.*, authors.author_name FROM books INNER JOIN authors ON authors.id=books.author_id INNER JOIN author_book_likes ON author_book_likes.book_id=books.id WHERE author_book_likes.author_id=:id;", array(":id"=>$author_id))->fetchAll();
  }
  else{
    $author=Null;
  }

  // check to see if they're trying to edit their entry

  if(isset($_GET['edit'])){
    $edit_mode=True;
    $sticky_all_genres=array();
    $sticky_all_genres[0]="filler";
    $dump=exec_sql_query($db, "SELECT tag from tags INNER JOIN tag_author ON tags.id=tag_author.tag_id WHERE tag_author.author_id=:author_id;", array(":author_id"=>$author['id']))->fetchAll();
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

  //like a book
  if(is_user_logged_in() && isset($_POST['book_like_id'])){
    if(!array_search($_POST['book_like_id'], $actual_ids)){
      exec_sql_query($db, "INSERT INTO author_book_likes (author_id, book_id) VALUES (:author_id, :book_id);", array(':author_id'=>current_user()['id'], ':book_id'=>trim($_POST['book_like_id'])));
      $liked_books=exec_sql_query($db, "SELECT books.*, authors.author_name FROM books INNER JOIN authors ON authors.id=books.author_id INNER JOIN author_book_likes ON author_book_likes.book_id=books.id WHERE author_book_likes.author_id=:id;", array(":id"=>$author_id))->fetchAll();
    }
  }

  if(is_user_logged_in() && isset($_POST['book_unlike'])){
    if(array_search($_POST['book_unlike_id'], $actual_ids)){
      exec_sql_query($db, "DELETE FROM author_book_likes WHERE author_id=:author_id AND book_id=:book_id", array(":author_id"=>current_user()['id'], ":book_id"=>$_POST['book_unlike_id']));
      $liked_books=exec_sql_query($db, "SELECT books.*, authors.author_name FROM books INNER JOIN authors ON authors.id=books.author_id INNER JOIN author_book_likes ON author_book_likes.book_id=books.id WHERE author_book_likes.author_id=:id;", array(":id"=>$author_id))->fetchAll();
      $already_liked=False;
      $already_disliked=True;
      unset($actual_ids[array_search($_POST['book_unlike_id'],$actual_ids)]);
    }
  }

  //delete a book
  if(is_user_logged_in() && $current_user['id']==$author['id'] && isset($_POST['book_delete'])){
    $to_delete=$_POST['to_delete'];
    exec_sql_query($db, "DELETE FROM books WHERE id=:to_delete", array(":to_delete"=>$to_delete));
    $books_by_author=exec_sql_query($db, "SELECT * FROM books WHERE author_id=:id;", array(':id'=>$author['id']))->fetchAll();

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
      exec_sql_query($db, "DELETE FROM author_author WHERE first_author_id=:x AND second_author_id=:y", array(":x"=>$current_user['id'], ':y'=>$_POST['second_author_id']));
      $existing=exec_sql_query($db, "SELECT * FROM author_author WHERE first_author_id=:first_author AND second_author_id=:second_author", array(":first_author"=>$current_user['id'], ":second_author"=>$author['id']))->fetchAll();
      $already_similar=count($existing)>0 || $current_user['id']==$author['id'];
      $similar_authors=exec_sql_query($db, "SELECT authors.* FROM authors INNER JOIN author_author ON authors.id=author_author.second_author_id WHERE author_author.first_author_id=:id;", array(":id"=>$author_id))->fetchAll();
    }
  }



  //add a new book written by this author
  $sticky_add_title='';
  $sticky_add_summary='';
  $sticky_add_pic_source=Null;
  $sticky_add_summary_source=Null;
  $sticky_mystery='';
  $sticky_fantasy='';
  $sticky_science_fiction='';
  $sticky_thriller='';
  $sticky_horror='';
  $sticky_romance='';
  $sticky_non_fiction='';

  $title_valid="hidden";
  $cover_pic_valid="hidden";
  $genres_valid="hidden";
  $summary_valid="hidden";

  if($edit_authorization && isset($_POST['add_book_by'])){
    $formValid=True;
    if(empty($_POST['add_title'])){
      $formValid=False;
      $title_valid="";
    }
    else{
      $sticky_add_title=trim($_POST['add_title']);
    }

    if(empty($_POST['add_summary'])){
      $formValid=False;
      $summary_valid="";
    }
    else{
      $sticky_add_summary=trim($_POST['add_summary']);
    }

    if(!empty($_POST['add_pic_source'])){
      $sticky_add_pic_source=trim($_POST['add_pic_source']);
    }
    if(!empty($_POST['add_summary_source'])){
      $sticky_add_summary_source=trim($_POST['add_summary_source']);
    }

    $any_genre_check=array(isset($_POST['fantasy']), isset($_POST['science-fiction']), isset($_POST['thriller']), isset($_POST['horror']), isset($_POST['mystery']), isset($_POST['romance']), isset($_POST['non-fiction']), isset($_POST['other']));

    if(!in_array(True, $any_genre_check)){
      $formValid=False;
      $genres_valid='';
    }
    else{
      $sticky_mystery=((bool)$_POST['mystery'] ? "checked" : '');
      $sticky_fantasy=((bool)$_POST['fantasy'] ? "checked" : '');
      $sticky_science_fiction=((bool)$_POST['science-fiction'] ? "checked" : '');
      $sticky_thriller=((bool)$_POST['thriller'] ? "checked" : '');
      $sticky_romance=((bool)$_POST['romance'] ? "checked" : '');
      $sticky_non_fiction=((bool)$_POST['non-fiction'] ? "checked" : '');
      $sticky_other=((bool)$_POST['other'] ? 'checked' : '');
    }

    $upload=$_FILES['add_pic'];
    if(!$upload['name']=='' && $upload['error']==UPLOAD_ERR_OK && $upload['size']<=MAX_FILE_SIZE){
      $new_filename=basename($upload['name']);
      $new_ext=strtolower(pathinfo($new_filename, PATHINFO_EXTENSION));
      if($new_ext!='svg' && $new_ext!="jpg" && $new_ext!='png' && $new_ext!='jpeg'){
        $formValid=False;
        $cover_pic_valid='';
      }
    }
    else{
      $formValid=False;
      $cover_pic_valid='';
    }

    if($formValid){
      $db->beginTransaction();
      exec_sql_query($db, "INSERT INTO books (title, field, pic_source, summary_source, summary, author_id) VALUES (:title, :field, :pic_source, :summary_source, :summary, :author_id);", array(':title'=>$sticky_add_title, ':field'=>$new_ext, ':pic_source'=>$sticky_add_pic_source, ':summary_source'=>$sticky_add_summary_source,':summary'=>$sticky_add_summary, 'author_id'=>$author['id']));
      $last_insert=$db->lastInsertId("id");
      for ($i=0; $i<count($any_genre_check); $i++){
        if ($any_genre_check[$i]){
          exec_sql_query($db, "INSERT INTO tag_book (tag_id, book_id) VALUES (:tag_id, :book_id)", array(":tag_id"=>$i, ":book_id"=>$last_insert));
        }
      }
      $new_path='public/uploads/books/' . $last_insert.'.'.$new_ext;
      move_uploaded_file($upload['tmp_name'], $new_path);
      $books_by_author=exec_sql_query($db, "SELECT * FROM books WHERE author_id=:id;", array(':id'=>$author['id']))->fetchAll();

      $db->commit();
    }
    else{
      $show_popup='';
    }
  }


  //edit an author's entry
  $sticky_name=$author['author_name'];
  $sticky_bio=$author['bio'];
  $sticky_pic_source=$author['pic_source'];
  $sticky_bio_source=$author['bio_source'];
  $image_error='hidden';


  if (isset($_POST['submit_author_edit'])){
    if(!is_null($_POST['edit_name'])){
      $sticky_name=trim($_POST['edit_name']);
    }

    if(!is_null($_POST['edit_bio'])){
      $sticky_bio=trim($_POST['edit_bio']);
    }

    if(!is_null($_POST['edit_pic_source'])){
      $sticky_pic_source=trim($_POST['edit_pic_source']);
    }

    if(!is_null($_POST['edit_bio_source'])){
      $sticky_bio_source=trim($_POST['edit_bio_source']);
    }

    if (isset($_POST['mystery']) && $sticky_mystery_edit!="checked"){
      exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (5, :author_id);", array(":author_id"=>$author['id']));
    }

    if(isset($_POST['fantasy']) && $sticky_fantasy_edit!="checked"){
      exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (1, :author_id);", array(":author_id"=>$author['id']));
    }

    if(isset($_POST['science-fiction']) && $sticky_science_fiction_edit!='checked'){
      exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (2, :author_id);", array(":author_id"=>$author['id']));
    }

    if(isset($_POST['thriller']) && $sticky_thriller_edit!='checked'){
      exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (3, :author_id);", array(":author_id"=>$author['id']));
    }

    if(isset($_POST['horror']) && $sticky_horror_edit!='checked'){
      exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (4, :author_id);", array(":author_id"=>$author['id']));
    }

    if(isset($_POST['romance']) && $sticky_romance_edit!='checked'){
      exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (6, :author_id);", array(":author_id"=>$author['id']));
    }

    if(isset($_POST['non-fiction']) && $sticky_non_fiction_edit!='checked'){
      exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (7, :author_id);", array(":author_id"=>$author['id']));
    }
    if(isset($_POST['other']) && $sticky_other_edit!='checked'){
      exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (8, :author_id);", array(":author_id"=>$author['id']));
    }

    $new_pic=$_FILES['edit_picture'];

    if ($sticky_name!=$author['name'] || trim($sticky_bio)!=$author['bio'] || $sticky_pic_source!=$author['pic_source'] || $sticky_bio_source!=$author['bio_source'] || !is_null($new_pic)){
      if($new_pic['name']==''){

        $db->beginTransaction();
        exec_sql_query($db, "UPDATE authors SET author_name=:author_name, bio=:bio, pic_source=:pic_source, bio_source=:bio_source WHERE id=:id;",array(":author_name"=>$sticky_name, ':bio'=>$sticky_bio, ':pic_source'=>$sticky_pic_source, ':bio_source'=>$sticky_bio_source, ':id'=>$author['id']));
        $author=exec_sql_query($db, "SELECT * FROM authors WHERE id=:id;", array(":id"=>$author_id))->fetchAll()[0];
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
          unlink("public/uploads/authors/".$author['id']. '.' . $author['field']);

          $db->beginTransaction();
          exec_sql_query($db, "UPDATE authors SET author_name=:author_name, bio=:bio, pic_source=:pic_source, field=:field, bio_source=:bio_source WHERE id=:id;",array(":author_name"=>$sticky_name, ':bio'=>$sticky_bio, ':pic_source'=>$sticky_pic_source, ':bio_source'=>$sticky_bio_source, ':id'=>$author['id'], ':field'=>$new_ext));
          $author=exec_sql_query($db, "SELECT * FROM authors WHERE id=:id;", array(":id"=>$author_id))->fetchAll()[0];
          $new_path="public/uploads/authors/".$author['id'].'.'.$new_ext;
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
  <?php if(is_null($author)){ ?>

    <section class="banner author_banner">

      <section class="description">
        <p class="breadcrumbs"><a href="/">Authors</a> > Author Not Found</p>
        <h1>Oops...Author Not Found</h1>
        <p>It looks like the page you're looking for no longer exists. This author's entry could have been deleted, the link you're following might be broken, or maybe the great planeswalkers that wander the cybersphere have simply decided that this page does not deserve to be. Please return to the main catalog to continue exploring our amazing books and authors.</p>
      </section>
      <figure>
        <img alt="picture of a maze" src="public/images/maze.jpg"/>
        <figcaption>Source: <a href="https://images.unsplash.com/photo-1590278458425-6aa3912a48a5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2249&q=80">Unsplash</a></figcaption>
        <!-- Source: https://images.unsplash.com/photo-1590278458425-6aa3912a48a5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2249&q=80-->
      </figure>
    </section>
  <?php } else{ ?>
    <section class="banner author_banner">
      <section class="description">
        <p class="breadcrumbs"><a href="/books">Authors</a> > <a href="/author?id=<?php echo $author_id;?>"><?php echo $author['author_name'];?></a></p>
        <?php if ($edit_mode && $edit_authorization) {?>
          <form class="edit_book" enctype='multipart/form-data' id='edit_author' action="<?php echo $current_page;?>" method="POST" novalidate>
            <section class="form_element">
              <label for="edit_name">Name:</label>
              <input type="text" id="edit_name" name="edit_name" value="<?php echo htmlspecialchars($author['author_name']);?>">
            </section>
            <section class="form_element">
              <label for="edit_bio">Bio:</label>
              <textarea cols=50 rows=15 id="edit_bio" name="edit_bio"><?php echo htmlspecialchars($author['bio']);?></textarea>
            </section>
            <section class="form_element">
              <label for='edit_bio_source'>Bio Source (Optional):</label>
              <input type='text' name='edit_bio_source' id='edit_bio_source' value="<?php echo htmlspecialchars($author['bio_source']);?>">
            </section>
            <section class="form_element">
              <label for='edit_pic_source'>Picture Source (Optional):</label>
              <input type='text' name='edit_pic_source' id='edit_pic_source' value='<?php echo htmlspecialchars($author['pic_source']);?>'>
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
        <?php } else{ ?>
          <h1><?php echo $author['author_name'];?></h1>
          <p><?php echo $author['bio'];?></p>
          <?php if($edit_authorization){?><div class="align-right"><a href="<?php echo $current_page . "&edit=True"?>" class="edit_button_banner">Edit Entry</a></div><?php } ?>
        <?php } ?>
      </section>
      <figure>
      <?php if ($edit_mode && $edit_authorization){?>
        <div class="banner_container">
          <img class="darken" alt="author pic" src="public/uploads/authors/<?php echo $author['id'] . '.' . $author['field'];?>"/>
          <input form='edit_author' name='edit_picture' type="file" id="edit_picture" accept=".png,.jpeg,.svg,.jpg">
          <input type="hidden" form='edit_author' name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
        </div>
      <?php } else{ ?>
        <img  alt="cover of the book" src="public/uploads/authors/<?php echo $author['id'] . '.' . $author['field'];?>"/>
      <?php } ?>
        <figcaption>
          Source: <a href="<?php echo $author['pic_source'];?>"><?php echo $author['author_name'];?></a>
          <!-- Source: <?php echo $author['pic_source'];?>-->
        </figcaption>
        <?php if(is_user_logged_in()){?>
          <form id='banner_similarity' method="POST" action=<?php echo $current_page;?>>
            <input type="hidden" name="second_author" value=<?php echo $author['id'];?>>
            <?php if (current_user()['id']==$author['id']){?>
              <button name="add_similarity" class="add_similarity_button_banner disabled">Add Similarity</button>
            <?php } else if($already_similar){?>
              <input type='hidden' name='second_author_id' value="<?php echo $author['id'];?>">
              <button type='submit' name='remove_similarity' class='add_similarity remove_similarity'>Remove Similarity</button>
            <?php } else{?>
              <button name="add_similarity" class="add_similarity_button_banner">Add Similarity</button>
            <?php } ?>
          </form>
        <?php }?>
      </figure>

  </section>
  <?php if ($edit_authorization && $edit_mode){?>
    <button type='submit' form='edit_author' id='submit_author_edit' name='submit_author_edit'>Submit</button>
  <?php } } ?>

  <section class="books_by">
    <h1>Books By <?php echo $author['author_name'];?>
      <?php if ($edit_authorization){?><button id='add_book'>(Add)</a><?php } ?>
  </h1>
    <ul class="entries">
      <?php foreach($books_by_author as $book){
        include("includes/book_entry.php");
      }?>
    </ul>
  </section>
  <section class="liked_books">
    <h1>Books that <?php echo $author['author_name'];?> Likes</h1>
      <ul class="entries">
        <?php foreach($liked_books as $book){
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
  <?php if($edit_authorization){?>
    <section class="popup <?php echo $show_popup;?>">
      <section class="popup_header">
        <h1>Add A Book</h1>
        <button id="close_popup">&times;</button>
      </section>
      <form action=<?php echo $current_page;?> method="POST" enctype='multipart/form-data'>
        <div class='column'>
          <section class="form_element">
            <label for="add_title">Title: </label>
            <input type='text' id="add_title" name="add_title" value="<?php echo $sticky_add_title;?>"/>
            <p class="feedback <?php echo $title_valid;?>">You must enter a title</p>
          </section>
          <section class="form_element">
            <label for="add_pic">Cover Picture: </label>
            <p class="feedback <?php echo $cover_pic_valid;?>">Please upload a jpg, png, or svg picture</p>
            <input type='file' id='add_pic' name='add_pic' accept=".png,.jpeg,.svg,.jpg"/>
            <input type="hidden" form='edit_book' name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />

          </section>
          <section class="form_element">
            <label for='add_pic_source'>Cover Picture Source URL (Optional): </label>
            <input type='text' id='add_pic_source' name='add_pic_source' value="<?php echo $sticky_add_pic_source;?>"/>

          </section>
          <section class="form_element add_genre">
            <h3>Genres:</h3>
            <p class='feedback <?php echo $genres_valid;?>'>You must select at least one genre</p>
            <section class="genre_grouping">
              <input type='checkbox' id="mystery" name='mystery' value='mystery' <?php echo $sticky_mystery;?>/>
              <label for="mystery">Mystery</label>
            </section>
            <section class="genre_grouping">
              <input type='checkbox' id="fantasy" name='fantasy' value='fantasy' <?php echo $sticky_fantasy;?>/>
              <label for='fantasy'>Fantasy</label>
            </section>
            <section class="genre_grouping">
              <input type='checkbox' id="science-fiction" name='science-fiction' value='science-fiction' <?php echo $sticky_science_fiction;?>/>
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
              <input type='checkbox' id="non-fiction" name='non-fiction' value='non-fiction' <?php echo $sticky_non_fiction;?>/>
              <label for='non-fiction'>Non-Fiction</label>
            </section>
            <section class="genre_grouping">
              <input type='checkbox' id='other' name='other' value='other' <?php echo $sticky_other;?>/>
              <label for='other'>Other</label>
            </section>
          </section>
        </div>
        <div class="column">
        <section class="form_element">
            <label for="add_summary">Summary: </label>
            <p class="feedback <?php echo $summary_valid;?>">You must include a summary of your book</p>
            <textarea name="add_summary" id="add_summary" cols=60 rows=15><?php echo $sticky_add_summary;?></textarea>
        </section>
        <section class="form_element">
            <label for="add_summary_source">Summary Citation (Optional): </label>

            <input type='text' id='add_summary_source' name='add_summary_source' value="<?php echo $sticky_add_summary_source;?>"/>
          </section>
        <section class="align-right">
            <button type="submit" name="add_book_by">Submit</button>
        </section>
        </div>
      </form>
    </section>
    <?php } ?>
</body>
</html>
