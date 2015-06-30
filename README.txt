Hey guys,

Welcome to the world of tomorrow! 

Here's what I think my architecture should look like, given the requirements:

A general class containing a registry of operands ('*', '*', '^', etc...) and handler functions to use to apply their operands to. Currently, I will restrict my implementation to 2 operands, which the challenge goes for, so I've got that going for me, which is nice. 

Calculator
	- registerOperand(operand, handler)
	- calculate(String command)
	- private parsing method behind the curtain
		- may be fun to have this handle parenthesis anyway. 

Post-mortem:
	Calculator parses expressions using order of operations and exposes an 
	interface allowing 3rd party users to add operations. 

	Current limitations:
		- Order of operations is a coincidence of when they register the operand 
		  handler. A bit leaky.
		- Operations can not be substrings of eachother, as that leads to 
		  undefined behavior. We will have to likely restrict them somewhat or 
		  use a regular expression style split function in our execute handler. 

		- Can not delete operators in an obvious fashion. 

** USAGE ** 

php main.php "[string to evaluate]"

In-code: Instantiate and add operators as desired. 