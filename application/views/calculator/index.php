<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= base_url('css/calculator/style.css') ?>" />
    <title>Calculator</title>
</head>

<body>
    <section class="calc">
        <div class="display">
            <input type="text" name="screen" id="screen" onkeydown="preventKey(event)" />
            <input
                type="text"
                name="answer"
                id="answer"
                readonly
                disabled />
        </div>

        <div class="column_one">
            <button>7</button>
            <button>8</button>
            <button>9</button>
            <button>DEL</button>
            <button>AC</button>
        </div>
        <div class="column_two">
            <button>4</button>
            <button>5</button>
            <button>6</button>
            <button>*</button>
            <button>/</button>
        </div>
        <div class="column_three">
            <button>1</button>
            <button>2</button>
            <button>3</button>
            <button>+</button>
            <button>-</button>
        </div>
        <div class="column_four">
            <button>0</button>
            <button>.</button>
            <button>ANS</button>
            <button id="expand">&#8644;</button>
            <button>=</button>
        </div>
    </section>
</body>
<script src="<?= base_url('js/calculator/script.js') ?> "></script>

</html>