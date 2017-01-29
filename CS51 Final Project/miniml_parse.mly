/* MiniML: a subset of ML
   Parser
   Stuart M. Shieber
   November 18, 2015
 */
		  
%{
  open Printf ;;
  open Expr ;;
%}

%token EOF
%token QUOTE
%token OPEN CLOSE
%token LET DOT IN REC
%token NEG
%token PLUS MINUS 
%token TIMES DIV
%token LESSTHAN EQUALS
%token IF THEN ELSE 
%token FUNCTION
%token RAISE
%token <string> ID
%token <int> INT
%token TRUE FALSE
%token <string> STRING
%token CONCAT
%token <float> FLOAT 
%token FNEG
%token FPLUS FMINUS
%token FTIMES FDIV
%token UNIT
%token L_BRACK
%token R_BRACK
%token SEP
%token CONS
%token LCONCAT

%left PLUS MINUS
%left TIMES DIV
%left CONCAT
%left FPLUS FMINUS
%left FTIMES FDIV

%right CONS
%left LCONCAT

%nonassoc LESSTHAN
%nonassoc EQUALS

%start input
%type <Expr.expr> input

/* Grammar follows */
%%
input:	exp EOF			{ $1 }

exp: 	exp expnoapp   		{ App($1, $2) }
	| expnoapp		{ $1 }

list_fields : exp   {[$1]}
    | exp SEP list_fields {$1 :: $3}

expnoapp: INT		{ Num $1 }
	| TRUE			{ Bool true }
	| FALSE			{ Bool false }
	| ID			{ Var $1 }
	| exp PLUS exp		{ Binop("+", $1, $3) }
	| exp MINUS exp		{ Binop("-", $1, $3) }
	| exp TIMES exp		{ Binop("*", $1, $3) }
	| exp DIV exp 		{ Binop("/", $1, $3)}
	| exp EQUALS exp	{ Binop("=", $1, $3) }
	| exp LESSTHAN exp	{ Binop("<", $1, $3) }
	| NEG exp			{ Unop("~", $2) }
	| IF exp THEN exp ELSE exp
	     	      	        { Conditional($2, $4, $6) }
	| LET ID EQUALS exp IN exp	{ Let($2, $4, $6) }
	| LET REC ID EQUALS exp IN exp	{ Letrec($3, $5, $7) }
	| FUNCTION ID DOT exp	{ Fun($2, $4) }	
	| RAISE					{ Raise }
	| UNIT					{ Unit }
	| OPEN exp CLOSE		{ $2 }  
	| QUOTE ID QUOTE		{Str $2}
	| QUOTE STRING QUOTE 	{Str $2}
	| QUOTE QUOTE 			{Str ""}
	| exp CONCAT exp 		{Binop("^", $1, $3)}
	| FLOAT 		 		{Float $1}
	| exp FPLUS exp 		{Binop("+.", $1, $3)}
	| exp FMINUS exp 		{Binop("-.", $1, $3)}
	| exp FTIMES exp 		{Binop("*.", $1, $3)}
	| exp FDIV exp 			{Binop("/.", $1, $3)}
	| FNEG exp  			{Unop("~.", $2)}
	| FUNCTION UNIT DOT exp	{Fun("()", $4) }
	| LET UNIT EQUALS exp IN exp 	{Let("()", $4, $6)}	
	| L_BRACK list_fields R_BRACK 	{List($2)}
	| L_BRACK R_BRACK				{List([])}
	| exp CONS exp 			{Binop("::", $1, $3)}
	| exp LCONCAT exp       {Binop("@", $1, $3)}
;

%%
