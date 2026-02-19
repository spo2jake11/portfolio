function preventKey(e) {
	e.preventDefault();
}

const screen = document.getElementById("screen");
const answerDisplay = document.getElementById("answer");
let lastAnswer = 0;

function isOperator(c) {
	return ["+", "-", "*", "/"].includes(c);
}

function calculate() {
	const expr = screen.value.replace(/\s/g, "");
	if (!expr) return;
	// Only allow digits, decimal point, and + - * /
	if (!/^[\d.+*\/\-]+$/.test(expr)) {
		answerDisplay.value = "Error";
		return;
	}
	try {
		const result = Function("return (" + expr + ")")();
		if (!Number.isFinite(result)) {
			answerDisplay.value = "Error";
			return;
		}
		lastAnswer = result;
		answerDisplay.value = result;
		screen.value = result;
	} catch (err) {
		answerDisplay.value = "Error";
	}
}

function click(key) {
	const v = screen.value;

	switch (key) {
		case "AC":
			screen.value = "0";
			answerDisplay.value = "";
			return;
		case "DEL":
			screen.value = v.slice(0, -1) || "0";
			return;
		case "=":
			calculate();
			return;
		case "ANS":
			screen.value = v === "0" ? String(lastAnswer) : v + lastAnswer;
			return;
		case "+":
		case "-":
		case "*":
		case "/":
			if (v && !isOperator(v.slice(-1))) screen.value = v + key;
			return;
		case ".":
			const lastNum = v.split(/[+\-*/]/).pop();
			if (lastNum && !lastNum.includes(".")) screen.value = v + ".";
			else if (!v) screen.value = "0.";
			return;
		default:
			if (/^\d$/.test(key)) {
				screen.value = v === "0" ? key : v + key;
			}
	}
}

document.querySelector(".calc").addEventListener("click", function (e) {
	const btn = e.target.closest("button");
	if (!btn) return;
	const key = btn.textContent;
	if (btn.id === "expand") {
		const a = screen.value;
		screen.value = answerDisplay.value || a;
		answerDisplay.value = a;
		return;
	}
	click(key);
});

document.addEventListener("keydown", function (e) {
	if (e.ctrlKey || e.metaKey || e.altKey) return;
	const active = document.activeElement;
	if (active && (active.tagName === "INPUT" || active.tagName === "TEXTAREA") && active !== screen) return;

	const k = e.key;
	if (/^[0-9]$/.test(k) || ["+", "-", "*", "/", "."].includes(k)) {
		e.preventDefault();
		click(k);
		return;
	}
	if (k === "Enter" || k === "=") {
		e.preventDefault();
		calculate();
		return;
	}
	if (k === "Backspace") {
		e.preventDefault();
		click("DEL");
		return;
	}
	if (k === "Escape") {
		e.preventDefault();
		click("AC");
		return;
	}
	if (k.toLowerCase() === "a") {
		e.preventDefault();
		click("ANS");
	}
});
