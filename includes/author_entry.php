<?php
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
        $similar_author_ids=exec_sql_query($db, "SELECT author_author.second_author_id FROM author_author WHERE author_author.first_author_id=:id;", array(":id"=>current_user()['id']))->fetchAll();
        for($i=0; $i<count($similar_author_ids); $i++){
            $actual_ids[$i+1]=$similar_author_ids[$i]['second_author_id'];
        }
        array_push($actual_ids, current_user()['id']);
    }
?>

<li class="entry">
    <a aria-label="<?php echo $author['author_name'];?>" href="/author?id=<?php echo $author['id'];?>">
        <figure>
        <img alt="author profile pic" src="public/uploads/authors/<?php echo $author['id'] . '.' . $author['field'];?>"/>
        <figcaption>Source: <a href="<?php echo $author['pic_source'];?>"><?php echo $author['author_name'];?></a></figcaption>
        </figure>

        <h3><?php echo $author['author_name'];?></h3>
    </a>
    <?php if (is_user_logged_in()){?>
        <form action=<?php echo $current_page?> method="POST">
            <input type="hidden" name='second_author' value=<?php echo $author['id'];?>>
            <?php if(current_user()['id']==$author['id']){?>
                <button class="add_similarity disabled">Add Similarity</button>
            <?php } else if (array_search($author['id'], $actual_ids)!=false) {?>
                <input type='hidden' name='second_author_id' value="<?php echo $author['id'];?>">
                <button type='submit' name='remove_similarity' class='add_similarity remove_similarity'>Remove Similarity</button>
            <?php } else{?>
                <input type='hidden' name='second_author_id' value="<?php echo $author['id'];?>">
                <button type="submit" name='add_similarity' class="add_similarity">Add Similarity</button>
            <?php } ?>
        </form>
    <?php } ?>
</li>
