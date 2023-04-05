
<?php if($total_pages != 1 && empty($_SESSION['search_result'])):?>

<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link" href="?page=1">Сначала</a>
        </li>

        <?php if($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo ($page - 1);?>"><</a>
            </li>
        <?php endif;?>
            
        <?php if($total_pages <= 2):?>
            <?php foreach(range(1, 2) as $value):?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $value;?>"><?php echo $value;?></a>
                </li>            
        <?php endforeach;?>
        <?php endif;?>
        
        <?php if($total_pages >= 3 && $page < 3):?>
            <?php foreach(range(1, 3) as $value):?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $value;?>"><?php echo $value;?></a>
                </li>
        <?php endforeach;?>
        <?php endif;?>

        <?php if($total_pages > 3 && $page > 2 && $page !== $total_pages):?>
            <?php foreach(range($page -1, $page +1) as $value):?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $value;?>"><?php echo $value;?></a>
                </li>
        <?php endforeach;?>
        <?php endif;?>

        <?php if($total_pages === $page && $total_pages != 2 && $total_pages != 3):?>
            <?php foreach(range($page -2, $page) as $value):?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $value;?>"><?php echo $value;?></a>
                </li>
        <?php endforeach;?>
        <?php endif;?>

        <?php if($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo ($page + 1);?>">></a>
            </li>
        <?php endif;?>

        <li class="page-item">
        <a class="page-link" href="?page=<?php echo $total_pages;?>">В конец</a>
        </li>
    </ul>
</nav>

<?php endif;?>