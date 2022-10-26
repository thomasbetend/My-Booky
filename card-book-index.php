
function cardBookIndex ($array1, $array2){
    return ( 
        <div class="album bg-light">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                <?php foreach($books as $book) { ?>
                    <div class="col">
                        <div class="card shadow-sm">

                            <div class="card-body text-center">
                                <h5 class="p-2 mb-1 bg-primary text-white"><?php echo ucwords(stripslashes($book['name'])) ?></h5>
                                <h5 class="pt-2 text-primary"><?php echo ucwords($book['firstname']) . ' ' . ucwords($book['lastname']) ?></h5>
                                <a href="book-info.php?id=<?php echo $book['id'] ?>" class="mt-0 mb-2">En savoir plus</a>
                                <p class="p-1 mb-0 text-black"><strong><?php echo 'Prix : ' . number_format($book['price_book'], 2, ',', ' ') . '€'?></strong></p>
                                <form name="<?php echo $book['id']?>" method="post" action="cart.php"><button type="submit" name="buttonCart" value='<?php echo $book['id']; ?>' class='btn btn-dark mt-2 mb-3'>ajouter au panier</button></form>
                                
                            </div>
                        </div>
                    </div>                       
                <?php } ?>  
            </div>
        </div>
    </div>)
}