<?php
    $menu="introduction";
    include "header.php"; 
?>
<body>
    <div class="hb"><?php echo $IntroductionTitle; ?></div>
    <hr />
    <h5  style="text-align: center;">POSTED ON OCTOBER 21, 2019 BY STEPHEN</h5>
    <div class="container_vertical" style='background-color:bisque;width:90%; height:90%; margin-left:auto; margin-right:auto'>
        <div class="htext"><?php echo $IntroductionInfo; ?></div>
            <iframe style="width:90%;height:80%"
                src="https://www.youtube.com/embed/9bi7BDbaUSA?autoplay=1&mute=1" frameborder="0" allowfullscreen title="Why Sơn Mài Painting Is So Expensive">
            </iframe>

    </div>
</body>
<?php
    include "footer.php";
?>

