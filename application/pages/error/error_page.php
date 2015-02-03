<style>
    
    .content{
        border:1px solid #ff0000;
        padding: 5px;
        width: 80%;
        margin: 0 auto;
    }
    
    h1{
        color: #ff0000;
        font-family: verdana;
        font-size: 23px;
        text-align: center;
    }
    p{
        color: #000;
        border:1px dotted #FF0000;
        padding:10px;
        font-family: verdana;
        font-size: 14px;
        text-align: center;
    }
    button{
        border: 1px solid #ff0000;
        color: #fff;
        padding: 5px;
        font-weight: bold;
        background-color: #ff0000;
        margin-left: 50%;
        cursor : pointer;
    }
    
    
</style>
<div class='content'>
    <h1><?php echo $titulo; ?></h1>
    <p>
        <?php echo $descripcion; ?>
    </p>
    <span align='center'><button  onclick='history.back()'>Volver</button></span>
</div>
<?php die(); ?>

