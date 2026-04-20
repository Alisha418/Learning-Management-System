// Import the function from file1.js
import { getElement } from './file1.js';

// Use the function
let element = getElement();
console.log(element); // Logs the <h1> element if it exists

// Example: Change the text of the <h1> element
if (element) {
    element.textContent = "Hello from file2.js!";
}
