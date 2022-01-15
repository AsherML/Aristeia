<?php
$title="Account Creation";

include("includes/init.php");
define("MAX_FILE_SIZE", 1000000);
$current_page="/accountCreation";

$sticky_name='';
$sticky_username='';
$sticky_password='';
$sticky_password_confirmation='';
$sticky_bio='';
$sticky_mystery='';
$sticky_fantasy='';
$sticky_science_fiction='';
$sticky_thriller='';
$sticky_horror='';
$sticky_romance='';
$sticky_non_fiction='';
$sticky_bio_source=Null;
$sticky_pic_source=Null;

$name_valid='hidden';
$username_valid='hidden';
$password_valid='hidden';
$confirmation_password_valid='hidden';
$bio_valid='hidden';
$genre_valid='hidden';
$pic_valid='hidden';

if(isset($_POST['submit_author_edit'])){
    $formValid=True;
    if(isset($_POST['name']) && trim($_POST['name'])!=""){
        $sticky_name=trim($_POST['name']);
    }
    else{
        $formValid=False;
        $name_valid='';
    }

    if(isset($_POST['username']) && trim($_POST['username'])!=""){
        $records=exec_sql_query($db, "SELECT * FROM authors WHERE username=:username;", array(":username"=>trim($_POST['username'])))->fetchAll();
        if(count($records)>0){
            $form_valid=False;
        }
        else{
            $sticky_username=trim($_POST['username']);
        }
    }
    else{
        $formValid=False;
        $username_valid='';
    }

    if(isset($_POST['password']) && trim($_POST['password']!="")){
        $sticky_password=trim($_POST['password']);
    }
    else{
        $formValid=False;
        $password_valid='';
    }

    if(isset($_POST['password_confirmation']) && trim($_POST['password_confirmation']==$sticky_password) && trim($_POST['password_confirmation'])!=""){
        $sticky_password_confirmation=trim($_POST['password_confirmation']);
        $hashed_password=password_hash($sticky_password, PASSWORD_DEFAULT);
    }
    else{
        $formValid=False;
        $confirmation_password_valid='';
    }
    if(isset($_POST['edit_bio']) && trim($_POST['edit_bio'])!=""){
        $sticky_bio=trim($_POST['edit_bio']);
    }
    else{
        $formValid=False;
        $bio_valid='';
    }

    $sticky_mystery=((bool)$_POST['mystery'] ? "checked" : '');
    $sticky_fantasy=((bool)$_POST['fantasy'] ? "checked" : '');
    $sticky_science_fiction=((bool)$_POST['science-fiction'] ? "checked" : '');
    $sticky_thriller=((bool)$_POST['thriller'] ? "checked" : '');
    $sticky_horror=((bool)$_POST['horror'] ? "checked":'');
    $sticky_romance=((bool)$_POST['romance'] ? "checked" : '');
    $sticky_non_fiction=((bool)$_POST['non-fiction'] ? "checked" : '');
    $sticky_other=((bool)$_POST['other'] ? 'checked' : '');

    if($sticky_mystery=='' && $sticky_fantasy=='' && $sticky_science_fiction=='' && $sticky_thriller=='' && $sticky_romance=='' && $sticky_non_fiction=='' && $sticky_other==''){
        $formValid=False;
        $genre_valid='';
    }

    $upload=$_FILES['edit_picture'];
    if(($upload['error']==UPLOAD_ERR_OK || $upload['error']==0) && $upload['size']<MAX_FILE_SIZE){
      $new_filename=basename($upload['name']);
      $new_ext=strtolower(pathinfo($new_filename, PATHINFO_EXTENSION));
      if($new_ext!='svg' && $new_ext!="jpg" && $new_ext!='png' && $new_ext!='jpeg'){
        $formValid=False;
        $pic_valid='';
      }
    }
    else{

      $formValid=False;
      $pic_valid='';
    }

    if(isset($_POST['edit_bio_source'])){
        $sticky_bio_source=trim($_POST['edit_bio_source']);
    }

    if(isset($_POST['edit_pic_source'])){
        $sticky_pic_source=trim($_POST['edit_pic_source']);
    }

    if($formValid){
        $db->beginTransaction();
        exec_sql_query($db, "INSERT INTO authors (author_name, field, bio_source, pic_source, bio, username, password) VALUES (:author_name, :field, :bio_source, :pic_source, :bio, :username, :password)", array(":author_name"=>$sticky_name, ':field'=>$new_ext, ':bio_source'=>$sticky_bio_source, ":pic_source"=>$sticky_pic_source, ':bio'=>$sticky_bio, ':username'=>$sticky_username, ':password'=>$hashed_password));
        $new_id=$db->lastInsertId('id');
        if($sticky_mystery!=''){
            exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (5, :author_id);", array(":author_id"=>$new_id));
        }
        if($sticky_fantasy!=''){
            exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (1, :author_id);", array(":author_id"=>$new_id));
        }
        if($sticky_science_fiction!=''){
            exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (2, :author_id);", array(":author_id"=>$new_id));
        }
        if($sticky_thriller!=''){
            exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (3, :author_id);", array(":author_id"=>$new_id));
        }
        if($sticky_horror!=''){
            exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (4, :author_id);", array(":author_id"=>$new_id));
        }
        if($sticky_romance!=''){
            exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (6, :author_id);", array(":author_id"=>$new_id));
        }
        if($sticky_non_fiction!=''){
            exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (7, :author_id);", array(":author_id"=>$new_id));
        }
        if($sticky_other!=''){
            exec_sql_query($db, "INSERT INTO tag_author (tag_id, author_id) VALUES (8, :author_id);", array(":author_id"=>$new_id));
        }
        $new_path='public/uploads/authors/' . $new_id.'.'.$new_ext;
        move_uploaded_file($upload['tmp_name'], $new_path);
        $db->commit();
        password_login($db, $messages, $sticky_username, $sticky_password);
        header("Location: /author?id=".$new_id);
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

    <section class="banner author_banner creation_banner">
      <section class="description">
          <h1>Create An Account</h1>
          <form class="edit_book" enctype='multipart/form-data' id='create_author' action="<?php echo $current_page;?>" method="POST" novalidate>
            <section class="form_element">
              <label for="name">Name: </label>
              <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($sticky_name);?>">
              <p class="feedback <?php echo $name_valid;?>">This field is required</p>
            </section>
            <section class="form_element">
                <label for='username_create'>Username: </label>
                <input type='text' id='username_create' name='username' value="<?php echo htmlspecialchars($sticky_username);?>">
                <p class='feedback <?php echo $username_valid;?>'>This username is taken</p>
            </section>
            <section class='form_element'>
                <label for='password_create'>Password: </label>
                <input type='password' id='password_create' name='password' value="<?php echo htmlspecialchars($sticky_password);?>">
                <p class="feedback <?php echo $password_valid;?>">This field is required</p>
            </section>
            <section class='form_element'>
                <label for='password_confirmation'>Confirm Password: </label>
                <input type='password' id='password_confirmation' name='password_confirmation' value='<?php echo htmlspecialchars($sticky_password_confirmation);?>'>
                <p class='feedback <?php echo $confirmation_password_valid;?>'>Your passwords must be both completed and matching</p>
            </section>

            <h2>What genres do you like to write:</h2>
            <p class="feedback <?php echo $genre_valid;?>">Please enter at least one genre</p>
            <section class="form_element genres genre_creation">
              <section class="genre_grouping">
                <input type='checkbox' id="mystery" name='mystery' <?php echo $sticky_mystery?>/>
                <label for="mystery">Mystery</label>
              </section>
              <section class="genre_grouping">
                <input type='checkbox' id="fantasy" name='fantasy' <?php echo $sticky_fantasy;?>/>
                <label for='fantasy'>Fantasy</label>
              </section>
              <section class="genre_grouping">
                <input type='checkbox' id="science-fiction" name='science-fiction' <?php echo $sticky_science_fiction;?>/>
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
                <input type='checkbox' id="non-fiction" name='non-fiction' value='non-fiction' <?php echo $sticky_non_fiction;?>/>
                <label for='non-fiction'>Non-Fiction</label>
              </section>
              <section class='genre_grouping'>
                <input type='checkbox' id='other' name='other' value='other' <?php echo $sticky_other;?>/>
                <label for='other'>Other</label>
              </section>
            </section>
      </section>
        <section class='column2'>
            <section class='form_element'>
                <label for='edit_picture'>Profile Picture:</label>
                <input form='create_author' name='edit_picture' type="file" id="edit_picture" accept=".png,.jpeg,.svg,.jpg">
                <input type="hidden" form='edit_author' name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
                <p class="feedback <?php echo $pic_valid;?>">You must enter a png, jpg, jpeg, or svg picture</p>
            </section>
            <section class="form_element">
              <label for="edit_bio">Bio:</label>
              <p class='feedback <?php echo $bio_valid;?>'>This field is required</p>
              <textarea cols=50 rows=15 id="edit_bio" name="edit_bio"><?php echo htmlspecialchars($sticky_bio);?></textarea>
            </section>
            <section class="form_element">
              <label for='edit_bio_source'>Bio Source URL (Optional):</label>
              <input type='text' name='edit_bio_source' id='edit_bio_source' value="<?php if (!is_null($sticky_bio_source)){echo htmlspecialchars($sticky_bio_source);}?>">
            </section>
            <section class="form_element">
              <label for='edit_pic_source'>Picture Source URL (Optional):</label>
              <input type='text' name='edit_pic_source' id='edit_pic_source' value='<?php if (!is_null($sticky_pic_source)){echo htmlspecialchars($sticky_pic_source);}?>'>
            </section>

        </section>

        </form>

  </section>
    <button type='submit' form='create_author' id='submit_author_edit' name='submit_author_edit'>Submit</button>
</body>
</html>
