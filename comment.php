<?php

/* displays book comments */

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory', 'root', '');

    /* insert comment in database */

    $queryInsertComment = 'INSERT INTO comment (user_id, book_id, content, post_date) VALUES (:user_id, :book_id, :content, :post_date)';
    $statementInsertComment = $pdo->prepare($queryInsertComment);
    $statementInsertComment->bindValue(':user_id', $_SESSION['id'], \PDO::PARAM_INT);
    $statementInsertComment->bindValue(':book_id', $book['id'], \PDO::PARAM_INT);
    $statementInsertComment->bindValue(':content', $_POST['comment'], \PDO::PARAM_STR);
    $statementInsertComment->bindValue(':post_date', date( "Y-m-d", time()), \PDO::PARAM_STR);
    $statementInsertComment->execute();



} ?>

<div class="card text-center mt-4">
    <form action="#" method="post">
        <input type="text" placeholder="Laisser un commentaire" name="comment" class="form-control">
    </form>
</div>

<!-- displays comments -->
<?php 
$queryComments = 'SELECT id, content, post_date, user_id FROM comment WHERE book_id = ' . $book['id'] . ' ORDER BY id DESC';
$statementComments = $pdo->query($queryComments);
$comments = $statementComments->fetchAll();

if($comments){
    foreach($comments as $comment){?>
        <div class="card text-center mt-4 pt-2 pb-0">
            <p><?php echo $comment['content'] ?></p>

            <!-- get comment user -->

            <?php $queryCommentUser = 'SELECT firstname, lastname FROM user WHERE id = ' . $comment['user_id'];
            $statementCommentUser = $pdo->query($queryCommentUser);
            $commentUser = $statementCommentUser->fetch(); ?>

            
            <div class="comment-options">

                <!-- delete comment only for user who posted the comment -->

                <?php  if($_SESSION['id'] === $comment['user_id']){ ?>
                        <a href="comment-delete.php?id=<?php echo $comment['id'];?>" class="delete-comment">Supprimer votre commentaire</a>
                <?php } ?>

                <!-- comment user -->

                <p class="legend-italic-right">Posté par <?php echo ucwords($commentUser['firstname'] . ' '. $commentUser['lastname']);?> le <?php echo $comment['post_date']; ?></p>

            </div>
        


        </div>

<?php }} ?>