# Calculator Module Documentation

This document describes the **Calculator** feature: a client-side, Windows-style calculator with a two-line display, temporary history panel, and no server-side calculation or database.

---

## Overview

- **URL:** `/calculator` (route: `calculator` → `calculator/calc`).
- **Controller:** `application/controllers/calculator/Calc.php` — loads a single view.
- **View:** `application/views/calculator/index.php` — HTML for display and buttons.
- **Script:** `js/calculator/script.js` — all logic (state, arithmetic, history).
- **Styles:** `css/calculator/style.css`.

No database or server-side math; everything runs in the browser.

---

## Display (Two Screens, Windows-Style)

Both lines are **read-only** and updated by the script.

| Element   | ID / Name | Purpose |
|-----------|-----------|--------|
| **Top**   | `#screen` / `name="screen"`  | Expression line: e.g. `2 + 3 =` (with spaces). Shown smaller. |
| **Bottom**| `#answer` / `name="answer"`   | Main display: current number being entered or the result. Shown larger. |

- Input is via **buttons** (and keyboard). Displays use `readonly` and `tabindex="-1"`; key events are handled at document level so both “screens” behave the same.

---

## Buttons and Keys

| Button / Key   | Action |
|----------------|--------|
| **0–9**        | Digit entry. After `=`, starts a new calculation. |
| **+ - * /**    | Operator. Commits current number as first operand (or chains from result), shows expression with spaces, clears main for next number. |
| **=** / Enter  | Compute and show result. Repeat `=` repeats last operation (e.g. 5 + 3 = 8, then 11, …). |
| **±**          | Toggle sign of the number on the main display (positive ↔ negative). |
| **.**         | Decimal point (at most one per number). |
| **AC** / Esc  | Clear all: expression, main display, and internal state. |
| **DEL** / Backspace | Backspace on main display only (or clear to `0` after result). |
| **⇄ (expand)**| Toggle the **History** panel open/closed beside the calculator. |

---

## Internal State (script.js)

- **expressionLine:** Text for top line (e.g. `2 + ` or `2 + 3 =`).
- **currentDisplay:** Text for bottom line (current number or result).
- **firstOperand, operator:** For one operation (e.g. `2 + 3`).
- **previousOperator, previousSecondOperand:** For repeat `=` (e.g. 5 + 3, then 8 + 3, …).
- **state:** `'initial'` \| `'after_operator'` \| `'after_result'`.
- **historyList:** Array of `{ expr, result }` for the session (temporary; no DB, no localStorage).

---

## Behavior Summary

1. **Initial:** You type a number on the main display; expression stays empty.
2. **After operator (e.g. 2 +):** Expression shows `2 + `; main display clears to `0` then shows the second number as you type.
3. **Equals:** Expression shows e.g. `2 + 3 =`, main shows `5`. Entry is added to history.
4. **After result:** Typing a digit starts a new calculation. Pressing an operator uses the result as first operand (e.g. 5 then `*` then 4 → 20).
5. **Repeat equals:** After `2 + 3 =` (5), pressing `=` again gives 5 + 3 = 8, then 8 + 3 = 11, etc.
6. **±:** Flips sign of the main display only (e.g. `3` ↔ `-3`).
7. **Division by zero:** Main display shows `Error`.

---

## History Panel

- **Toggle:** ⇄ (expand) button; panel opens/closes beside the calculator.
- **Content:** List of “expression = result” for the current session. Stored in `historyList` only (lost on refresh).
- **Clear:** “Clear” button empties the list.
- **Click entry:** Puts that result on the main display and clears expression (starts a new calculation with that number).

---

## File Layout

```
application/
  controllers/calculator/
    Calc.php              # index() → load calculator view
  views/calculator/
    index.php             # Markup: display inputs, buttons, history aside

js/calculator/
  script.js               # State, compute(), click(), history, keyboard

css/calculator/
  style.css               # Wrapper, display, buttons, history panel
```

---

## Routes

| URL         | Controller → Method   |
|------------|------------------------|
| `calculator` | `calculator/Calc/index` → loads `calculator/index` view |

---

## Dependencies

- CodeIgniter `base_url()` for assets: `base_url('css/calculator/style.css')`, `base_url('js/calculator/script.js')`.
- No PHP calculation; no database or config specific to the calculator.
