Hey guys,

Welcome to the world of tomorrow! 

Here's what I think my architecture should look like, given the requirements:

A general class containing a registry of operands ('*', '*', '^', etc...) and handler functions to use to apply their operands to. Currently, I will restrict my implementation to 2 operands, which the challenge goes for, so I've got that going for me, which is nice. 

Calculator
	- registerOperand(operand, handler)
	- calculate(String command)
	- private parsing method behind the curtain
		- may be fun to have this handle parenthesis anyway. 

Should you require a theme song while peruisng my code, might I recommend Montefiori Cocktail? Their elevator-esque music should blend into the background nicely. 

