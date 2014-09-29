<?php
/*
*
* Yöneticilere verileri listeleyen sayfa
*
* Verileri bu tablo vasıtasıyla listeleyip,
* ID'ye göre silme ve düzenleme linklerini oluşturacağız.
*
* @author Midori Kocak 2014
*
*/
?>
<div class="row">
    <div class="large-4 columns">
        <form action="<?= LINK_PREFIX ?>/Files/add" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="large-12 columns">
                    <label>Dosya
                        <input type="file" id="file" name="file" />
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <button type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="large-8 columns">
        <?php
        for($i=0;$i<count($files);$i++)
        {
            ?>
            <div class="large-3 columns media">
                <img src="<?=FILE_PREFIX?>/images/<?=$files[$i]['filename']?>" alt="<?=$files[$i]['id']?>" /><br/>
                <a href="<?= LINK_PREFIX ?>/Files/Delete/<?=$files[$i]['id']?>">Sil</a>
            </div>
            <?php
        }
        ?>
    </div>
</div>
