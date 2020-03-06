<?php
  $valet_xdg_home = getenv('HOME') . '/.config/valet';
  $valet_old_home = getenv('HOME') . '/.valet';
  $valet_home_path = is_dir($valet_xdg_home) ? $valet_xdg_home : $valet_old_home;
  $valet_config = json_decode(file_get_contents("$valet_home_path/config.json"));
  $tld = isset($valet_config->tld) ? $valet_config->tld : $valet_config->domain;
?>

<html lang="en">
  
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./dist/styles/style.css">
  <title>Valet</title>
</head>

<body>
  <div class="container">
    
    <div class="logo">
      <svg width="70px" height="105px" viewBox="0 0 70 105" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
          <linearGradient x1="55.7406195%" y1="15.9877232%" x2="46.986146%" y2="68.3517654%" id="linearGradient-1">
            <stop stop-color="#EEEEEE" offset="0%"></stop>
            <stop stop-color="#2BD2FF" offset="59.8820265%"></stop>
            <stop stop-color="#FA8BFF" offset="100%"></stop>
          </linearGradient>
        </defs>
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" font-family="Akronim-Regular, Akronim" font-size="140" font-weight="normal">
          <g id="Desktop-HD" transform="translate(-513.000000, -92.000000)" fill="url(#linearGradient-1)">
            <text id="V">
              <tspan x="512.07" y="196">V</tspan>
            </text>
          </g>
        </g>
      </svg>
      <h1>valet</h1>
    </div><!-- /.logo -->

    <div class="grid grid-one">
      <div class="grid grid-two">

      <?php
        foreach ($valet_config->paths as $parked_path) :
          foreach (scandir($parked_path) as $site) :
            if ((is_dir("$parked_path/$site") || is_link("$parked_path/$site")) && $site[0] != '.') : ?>

            <div class="box box-light">

              <div class="site-name">
                <?= $site ?>
              </div><!-- /.site -->

              <div class="site-url">
                <span>URL:</span>
                <a href="http://<?= "$site.$tld" ?>/" target="<?= "valet_$site" ?>"><?= "$site.$tld" ?></a>
              </div><!-- /.url -->

              <div class="site-folder">
                <span>Folder:</span>
                <code><?= str_replace(getenv('HOME'), '', "$parked_path/$site") ?></code>
              </div><!-- /.folder -->

            </div><!-- /.box -->

          <?php
            endif;
          endforeach;
        endforeach;
      ?>
      </div><!-- /.grid -->

      <aside id="sidebar">

        <div class="grid grid-three">

          <div class="box box-dark">
            <h3>Helpful Commands</h3>
            <div>
              <span>New site:</span>
              <code>wp valet new sitename</code>
            </div>
            <div>
              <span>Destroy site:</span>
              <code>wp valet destroy sitename</code>
            </div>
            
          </div><!-- /.box box-dark -->

          <div class="box box-dark">
            <h3>phpMyAdmin</h3>
            <div>
              <span>User:</span>
              <code>root</code>
            </div>
            <div>
              <span>Pass:</span>
              <code>&nbsp;&nbsp;&nbsp;&nbsp;</code>
            </div>
            <a href="http://phpmyadmin.<?= $tld ?>" target="_blank" class="button">phpMyAdmin</a>
            
          </div><!-- /.box box-dark -->

        </div><!-- /.grid -->
      </aside><!-- /#sidebar -->

    </div><!-- /.grid -->
  </div><!-- /.container -->
</body>
</html>