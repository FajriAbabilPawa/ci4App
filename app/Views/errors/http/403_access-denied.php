<?php
// !
// ! Gabisa dipake tanpa dark theme (???????) 
// !
?>
<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>

<div id="app">
    <div>403</div>
    <div class="txt">
        Access denied
        <br>
        Pls go <a href="
        <?php
        if (session()->get('role') == "admin") {
            echo base_url('admin');
        } elseif (session()->get('role') == "member") {
            echo base_url('member');
        } else {
            echo base_url('login');
        }
        ?>">back</a><span class="blink">_</span>

    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css?family=Press+Start+2P');

    :root {
        --color: #54FE55;
        --color2: #1a4f1a;
        --color-a: #34eb7d;
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
<?= $this->endSection() ?>