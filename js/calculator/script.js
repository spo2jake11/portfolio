function preventKey(e) {
	e.preventDefault();
}

const expressionDisplay = document.getElementById("screen");
const mainDisplay = document.getElementById("answer");
let historyList = [];

// Windows-style state
let expressionLine = "";
let currentDisplay = "0";
let firstOperand = null;
let operator = null;
let previousOperator = null;
let previousSecondOperand = null;
let state = "initial"; // 'initial' | 'after_operator' | 'after_result'

function updateDisplays() {
	expressionDisplay.value = expressionLine;
	mainDisplay.value = currentDisplay || "0";
}

function parseNum(s) {
	if (s === "" || s === "-") return 0;
	const n = parseFloat(s);
	return Number.isFinite(n) ? n : 0;
}

function formatResult(n) {
	if (!Number.isFinite(n)) return "Error";
	if (Number.isInteger(n)) return String(n);
	const s = n.toFixed(10).replace(/\.?0+$/, "");
	return s;
}

function compute(a, op, b) {
	const x = parseNum(String(a));
	const y = parseNum(String(b));
	switch (op) {
		case "+": return x + y;
		case "-": return x - y;
		case "*": return x * y;
		case "/": return y === 0 ? NaN : x / y;
		default: return NaN;
	}
}

function doEquals() {
	if (state === "after_operator") {
		const second = currentDisplay === "" ? "0" : currentDisplay;
		const result = compute(firstOperand, operator, second);
		if (!Number.isFinite(result)) {
			mainDisplay.value = "Error";
			return;
		}
		const formatted = formatResult(result);
		previousOperator = operator;
		previousSecondOperand = parseNum(second);
		expressionLine = firstOperand + " " + operator + " " + second + " =";
		currentDisplay = formatted;
		state = "after_result";
		historyList.unshift({
			expr: String(firstOperand) + operator + second,
			result: result
		});
		renderHistory();
	} else if (state === "after_result" && previousOperator != null && previousSecondOperand != null) {
		const result = compute(parseNum(currentDisplay), previousOperator, previousSecondOperand);
		if (!Number.isFinite(result)) {
			mainDisplay.value = "Error";
			return;
		}
		const formatted = formatResult(result);
		expressionLine = currentDisplay + " " + previousOperator + " " + previousSecondOperand + " =";
		currentDisplay = formatted;
		historyList.unshift({
			expr: currentDisplay + previousOperator + previousSecondOperand,
			result: result
		});
		renderHistory();
	}
	updateDisplays();
}

function toggleSign() {
	if (currentDisplay === "0" || currentDisplay === "") {
		currentDisplay = "-";
	} else if (currentDisplay === "-") {
		currentDisplay = "0";
	} else if (currentDisplay.startsWith("-")) {
		currentDisplay = currentDisplay.slice(1);
	} else {
		currentDisplay = "-" + currentDisplay;
	}
	updateDisplays();
}

function renderHistory() {
	const listEl = document.getElementById("historyList");
	const emptyEl = document.getElementById("historyEmpty");
	if (!listEl || !emptyEl) return;
	listEl.innerHTML = "";
	if (historyList.length === 0) {
		emptyEl.style.display = "block";
		return;
	}
	emptyEl.style.display = "none";
	historyList.forEach(function (item) {
		const li = document.createElement("li");
		li.className = "history-item";
		li.innerHTML = "<span class=\"history-expr\">" + escapeHtml(item.expr) + "</span> <span class=\"history-eq\">=</span> <span class=\"history-result\">" + escapeHtml(String(item.result)) + "</span>";
		li.addEventListener("click", function () {
			currentDisplay = String(item.result);
			expressionLine = "";
			state = "initial";
			firstOperand = null;
			operator = null;
			previousOperator = null;
			previousSecondOperand = null;
			updateDisplays();
		});
		listEl.appendChild(li);
	});
}

function escapeHtml(s) {
	const div = document.createElement("div");
	div.textContent = s;
	return div.innerHTML;
}

function click(key) {
	switch (key) {
		case "AC":
			expressionLine = "";
			currentDisplay = "0";
			firstOperand = null;
			operator = null;
			previousOperator = null;
			previousSecondOperand = null;
			state = "initial";
			updateDisplays();
			return;
		case "DEL":
			if (state === "after_result") {
				currentDisplay = "0";
				state = "initial";
			} else if (currentDisplay.length <= 1 || currentDisplay === "-") {
				currentDisplay = "0";
			} else {
				currentDisplay = currentDisplay.slice(0, -1);
			}
			updateDisplays();
			return;
		case "=":
			doEquals();
			return;
		case "±":
		case "+/-":
			toggleSign();
			return;
		case "+":
		case "*":
		case "/":
			if (state === "after_result") {
				firstOperand = parseNum(currentDisplay);
				operator = key;
				expressionLine = currentDisplay + " " + key + " ";
				currentDisplay = "0";
				state = "after_operator";
			} else if (state === "after_operator") {
				if (currentDisplay !== "" && currentDisplay !== "0") {
					const result = compute(firstOperand, operator, currentDisplay);
					if (!Number.isFinite(result)) {
						mainDisplay.value = "Error";
						updateDisplays();
						return;
					}
					firstOperand = result;
					operator = key;
					expressionLine = formatResult(result) + " " + key + " ";
					currentDisplay = "0";
				} else {
					operator = key;
					expressionLine = firstOperand + " " + key + " ";
				}
			} else {
				firstOperand = parseNum(currentDisplay);
				operator = key;
				expressionLine = currentDisplay + " " + key + " ";
				currentDisplay = "0";
				state = "after_operator";
			}
			updateDisplays();
			return;
		case "-":
			if (state === "after_result") {
				firstOperand = parseNum(currentDisplay);
				operator = "-";
				expressionLine = currentDisplay + " - ";
				currentDisplay = "0";
				state = "after_operator";
			} else if (state === "after_operator") {
				if (currentDisplay !== "" && currentDisplay !== "0") {
					const result = compute(firstOperand, operator, currentDisplay);
					if (!Number.isFinite(result)) {
						mainDisplay.value = "Error";
						updateDisplays();
						return;
					}
					firstOperand = result;
					operator = "-";
					expressionLine = formatResult(result) + " - ";
					currentDisplay = "0";
				} else {
					operator = "-";
					expressionLine = firstOperand + " - ";
				}
			} else {
				firstOperand = parseNum(currentDisplay);
				operator = "-";
				expressionLine = currentDisplay + " - ";
				currentDisplay = "0";
				state = "after_operator";
			}
			updateDisplays();
			return;
		case ".":
			if (state === "after_result") {
				currentDisplay = "0.";
				state = "initial";
			} else if (!currentDisplay.includes(".")) {
				currentDisplay = currentDisplay === "" || currentDisplay === "-" ? currentDisplay + "0." : currentDisplay + ".";
			}
			updateDisplays();
			return;
		default:
			if (/^\d$/.test(key)) {
				if (state === "after_result") {
					currentDisplay = key;
					expressionLine = "";
					state = "initial";
					firstOperand = null;
					operator = null;
				} else if (currentDisplay === "0" && key !== "0") {
					currentDisplay = key;
				} else if (currentDisplay !== "0" || key !== "0") {
					currentDisplay = currentDisplay === "0" ? key : currentDisplay + key;
				}
				updateDisplays();
			}
	}
}

document.querySelector(".calc").addEventListener("click", function (e) {
	const btn = e.target.closest("button");
	if (!btn) return;
	const key = btn.textContent;
	if (btn.id === "expand") {
		const historyPanel = document.getElementById("calcHistory");
		const isOpen = historyPanel.getAttribute("aria-hidden") === "false";
		if (isOpen) {
			historyPanel.setAttribute("aria-hidden", "true");
			historyPanel.classList.remove("is-open");
		} else {
			historyPanel.setAttribute("aria-hidden", "false");
			historyPanel.classList.add("is-open");
		}
		return;
	}
	if (btn.id === "negate") {
		click("±");
		return;
	}
	click(key);
});

document.addEventListener("keydown", function (e) {
	if (e.ctrlKey || e.metaKey || e.altKey) return;
	const active = document.activeElement;
	if (active && (active.tagName === "INPUT" || active.tagName === "TEXTAREA") && active.id !== "screen" && active.id !== "answer") return;

	const k = e.key;
	if (/^[0-9]$/.test(k) || ["+", "-", "*", "/", "."].includes(k)) {
		e.preventDefault();
		click(k);
		return;
	}
	if (k === "Enter" || k === "=") {
		e.preventDefault();
		click("=");
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
});

document.getElementById("historyClear").addEventListener("click", function () {
	historyList = [];
	renderHistory();
});

updateDisplays();
