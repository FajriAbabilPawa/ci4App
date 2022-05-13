<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<style>
    @import url('https://fonts.googleapis.com/css?family=Press+Start+2P');

    :root {
        --color: #34ebe8;
        --color2: #34b4eb;
        --color-a: #3459eb;
        --glowSize: 10px;
    }

    html,
    body {
        width: 100%;
        height: 100%;
        margin: 0px;
    }

    * {
        font-family: 'Press Start 2P', cursive;
        box-sizing: border-box;
    }

    #app {
        padding: 1rem;
        background: black;
        display: flex;
        height: 100%;
        justify-content: center;
        align-items: center;
        color: var(--color);
        text-shadow: 0px 0px var(--glowSize);
        font-size: 6rem;
        flex-direction: column;
    }

    .txt {
        color: var(--color);
        font-size: 1.8rem;
    }

    a {
        color: var(--color-a);
        text-decoration: none;
        font-size: 1.8rem;
    }


    @keyframes blink {
        0% {
            opacity: 0
        }

        49% {
            opacity: 0
        }

        50% {
            opacity: 1
        }

        100% {
            opacity: 1
        }
    }

    .blink {
        animation-name: blink;
        animation-duration: 1s;
        animation-iteration-count: infinite;
    }
</style>
<div id="app">
    <div>404</div>
    <p class="txt">File Not Found</p>
    <p class="txt">
        <?php if (!empty($message) && $message !== '(null)') : ?>
            <?= nl2br(esc($message)) ?>
        <?php else : ?>
            Sorry! Cannot seem to find the page you were looking for.
        <?php endif ?>
    </p>
    <br>
    <a href="<?php
                if (session()->get('role') == "admin") {
                    echo base_url('admin');
                } elseif (session()->get('role') == "member") {
                    echo base_url('member');
                } else {
                    echo base_url('login');
                }
                ?>">Go Back?</a><span class="blink">_</span>

</div>


<?= $this->endSection() ?>