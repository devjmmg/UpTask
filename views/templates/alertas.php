<?php 

foreach($alertas as $key => $value): 

    foreach($value as $alerta):

?>
        
        <div class="alerta <?php echo $key; ?>">

        <?php echo $alerta; ?>
        
        </div>
        
<?php 
        
    endforeach;

endforeach; 

?>