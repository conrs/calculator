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
	Calculator parses expressions using order of operations and exposes an interface allowing 3rd party users to add operations. 

	Current limitations:
		- Order of operations is a coincidence of when they register the operand handler. A bit leaky.

		- Operations can not be substrings of eachother, as that leads to undefined behavior. We will have to likely restrict them somewhat or use a regular expression style split function in our execute handler. 

		- Can not delete operators in an obvious fashion. 

		- Precedence of addition versus subtraction is odd. Should be essentially at the same level, system currently treats subtraction as less than addition leading to non-intuitive behaviour (it should fall back to evaluating left-to-right in that case)

			Modifying our operator registration function to accept priorities and iterating through every operand of the same priority in an inner loop inside execute should resolve this issue. 

		- Eventual creation of Operation class to encapsulate number of operands and calculation would be a good move going forward should complexity increase. Changing the operation datastructure from an associative arary to a priority bucketed collection of Operations would help with operand precedence.

** USAGE ** 

php main.php "[string to evaluate]"

In-code: Instantiate and add operators as desired. 