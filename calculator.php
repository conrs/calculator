<?php
namespace MattsSuperFunBox;

/* Calculator:

	Provides a simple parser of most arithmetic functions. You may register an operand and 
	a handler function to define new functionality as-needed. 

	If you want a basic no-frills calculator, simply call the factory function:
		makeBasicCalculator

	Notes: 
		
		- Only handles 2-operand expressions currently. 
		- Order of operand registration matters at the moment. 
*/
class Calculator
{
	private $operand_handlers = array();

	
	/* makeBasicCalculator:

		Factory method for producing a calculator object with the usual operators
		( '**', 'v', '/', '*', '+', '-' )
	*/

	public static function makeBasicCalculator()
	{
		$ret = new self(); 

		// Note: Order of addition matters here, 

		$ret->addOperator("**", function($op_1, $op_2)
		{
			return pow($op_1, $op_2);
		});

		$ret->addOperator("/", function($op_1, $op_2) 
		{
			return $op_1 / $op_2; 
		});

		$ret->addOperator("*", function($op_1, $op_2) 
		{
			return $op_1 * $op_2; 
		});

		$ret->addOperator("+", function($op_1, $op_2) 
		{
			return $op_1 + $op_2; 
		});

		$ret->addOperator("-", function($op_1, $op_2) 
		{
			return $op_1 - $op_2; 
		});

		return $ret;
	}

	public function __construct()
	{
		// Do nothing in here yet. Wheeeeeeeeee
	}

	/* addOperator:

		Adds the passed operator (which for now can be any string) and its handler
		to our data structure to use when parsing commands. 

		Note: Order of addition matters here, earlier that you add it the higher 
		precedence it has. This is an awkward gotcha.
		TODO: Add a priority level customizable by the user. 

		@param operator: Operator string (e.g. *)

		@param handler: Handler function accepting two arguments (the left and right
						operand, respectively) which goes ahead and returns the result
						you desire. Please have it be numeric, other stuff is probably
						non-intuitive. 
	*/

	public function addOperator($operator, callable $handler)
	{
		// TODO: basic return checking on handler to ensure numeric results, should we care.

		$this->operand_handlers[$operator] = $handler;
	}


	private function getOperatorResult($operand_1, $operation, $operand_2)
	{
		$ret = false;

		echo "Evaluating $operand_1 $operation $operand_2\n";

		if(isset($this->operand_handlers[$operation]))
		{
			$ret = $this->operand_handlers[$operation]($operand_1, $operand_2); 
		}
		else
		{
			throw new Exception("Unparsable operand '$operation'.");	// TODO: more feature-rich exceptions further up the chain
		}

		return $ret;
	}

	/* parse:

		This is where things get nuanced and actually kind of intriguing. My approach here will be to detect sub-parseable 
		areas in any passed string, isolating those areas, and re-invoking parse on the constituent parts. Thus, it's a 
		recursive solution to a problem which will pay dividends later should we wish to add brackets or the like, or 
		flesh out our orders of operation better. 
	*/

	public function execute($str)
	{
		// Basic approach: Look for a registered operand in the string, giving precedence to those near the top of our handler array. 
		// Should we find one, split the string on it, keep track of it, and invoke ourselves again with each "side" of the string. 

		// Hold on to your butts...

		$result = 0; 
		$found_it = false;

		// TODO: Iterate backwards without having to reverse array, this is just a shortcut of inefficiency. Use that 
		// in conjunction with found boolean to make code prettier. 

		$handlers = $this->operand_handlers;

		foreach($handlers as $key => $value)
		{
			echo "Checking $key\n";
			if(stristr($str, $key))
			{
				echo "\n\tFound $key\n";
				// Hey, we have that operator! Let's split ourselves up and find out what our operands are. 
				$tokens = explode($key, $str);

				$result += $this->getOperatorResult($this->execute($tokens[0]), $key, $this->execute($tokens[1]));

				$found_it = 1;
			}
		}

		// Here's our base case handler. Should we have gone through the entire set of registered handlers and not found one, we probably have
		// an atom on our hands and thus for now let's simply try and parse it into numeric form. [ This is another point of customization we could
		// have ].

		if(!$found_it) 
		{
			// :(
			echo "\n\t Atom $str found.\n";

			$result = 0 + $str;		// rely on PHP's magic type coersion for now. #yolo
		}

		return $result;
	}
}

?>