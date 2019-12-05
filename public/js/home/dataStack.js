/**
* @name    : JS Data Structures
* @author  : Xabadu
* @license : open 
* @repository: https://github.com/Xabadu/js-data-structures
* @version 1 on 19 Apr 2018
* @description JS Data Structures
*/
/**
 * @version 1.1 on 03 Dic 2019
 * @author @jorgedipra
 * @constructor
 *   @ this.stack = {};
 *   @ this.count = 0;
 * @Methods:
 *   @ push  :  agrega nuevo elemento
 *   @ pop   :  desocupa un elemnto
 *   @ peek  :  muestra el ultimo elemento
 *   @ size  :  cantidad de elementos
 *   @ cero  :  elimina el objeto
 *   @ all   :  retorna todos los element
 *   @ one   :  retorna elemento selecionado
 *   @ print :  imprime por consola
 */
class Stack {
    constructor() {
      this.stack = {};
      this.count = 0;
    }
  
    push(element) {
      this.stack[this.count] = element;
      this.count++;
      return this.stack;
    }  
    pop() {
      this.count--;
      const element = this.stack[this.count];
      delete this.stack[this.count];
      return element;
    }
  
    peek() {
      return this.stack[this.count - 1];
    }
  
    size() {
      return this.count;
    }
    
    cero(){
        delete this.stack;
        return false;  
    }
    all(){
      return this.stack;
    }
    one(i){
      return this.stack[i];
    }

    print() {
      console.log(this.stack);
    }
  }
  const stack = new Stack();
/**
  @example #NOTE
 * 
console.log(stack.size()); // 0
console.log(stack.push('John Cena')); // { '0': 'John Cena' }
console.log(stack.size()); // 1
console.log(stack.peek()); // John Cena
console.log(stack.push('The Rock')); // { '0': 'John Cena', '1': 'The Rock' }
console.log(stack.size()); // 2
stack.print(); // { '0': 'John Cena', '1': 'The Rock' }
console.log(stack.peek()); // The Rock
console.log(stack.pop()); // The Rock
stack.print(); // { '0': 'John Cena' }
console.log(stack.size()); // 1
console.log(stack.peek()); // John Cena
*
 */