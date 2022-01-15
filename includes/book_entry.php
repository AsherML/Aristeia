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
        $liked_books_ids=exec_sql_query($db, "SELECT books.id FROM books INNER JOIN author_book_likes ON author_book_likes.book_id=books.id WHERE author_book_likes.author_id=:id;", array(":id"=>current_user()['id']))->fetchAll();
        for($i=0; $i<count($liked_books_ids); $i++){
            $actual_ids[$i+1]=$liked_books_ids[$i]['id'];
        }
    }
?>

    <li class="entry">
    <a aria-label="<?php echo $book['title'];?>" href="/book?id=<?php echo $book['id'];?>">
    <figure>
    <?php if (is_user_logged_in() && $author['id']==$book['author_id']){?>
        <div class="container">
            <img alt="book cover" src="public/uploads/books/<?php echo $book['id'] . '.' . $book['field'];?>"/>
            <form action=<?php echo $current_page;?> method="POST">
                <button type="submit" class="book_delete hidden" name="book_delete">Delete</button>
                <input type="hidden" name="to_delete" value="<?php echo $book['id'];?>"/>
            </form>
        </div>
    <?php } else{?>
        <img alt="book cover" src="public/uploads/books/<?php echo $book['id'] . '.' . $book['field'];?>"/>
    <?php } ?>


    <figcaption>Source: <a href="<?php echo $book['pic_source'];?>"><?php echo $book['title'];?></a></figcaption>
    </figure>
    </a>
    <h3><?php echo $book['title'];?></h3>
    <?php if(is_user_logged_in()){?>
        <?php if (array_search($book['id'], $actual_ids)){?>
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
    </li>
