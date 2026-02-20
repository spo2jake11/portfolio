<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= base_url('css/calculator/style.css') ?>" />
    <title>Calculator</title>
</head>

<body>
    <div class="title text-light">
        <h1 class="">Simple Calculator</h1>
    </div>
    <div class="calculator-wrapper">
        <section class="calc">
            <div class="display">
                <input type="text" name="screen" id="screen" readonly tabindex="-1" aria-label="Expression" onkeydown="preventKey(event)" />
                <input type="text" name="answer" id="answer" readonly tabindex="-1" aria-label="Result" onkeydown="preventKey(event)" />
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
            <button id="negate">±</button>
            <button id="expand">&#8644;</button>
            <button>=</button>
        </div>
        </section>
        <aside class="calc-history" id="calcHistory" aria-hidden="true">
            <div class="history-header">
                <h3 class="history-title">History</h3>
                <button type="button" class="history-clear" id="historyClear" title="Clear history">Clear</button>
            </div>
            <ul class="history-list" id="historyList"></ul>
            <p class="history-empty" id="historyEmpty">No calculations yet.</p>
        </aside>
    </div>
</body>
<script src="<?= base_url('js/calculator/script.js') ?> "></script>

</html>