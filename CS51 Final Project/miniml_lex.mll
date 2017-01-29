{
  open Printf ;;
  open Miniml_parse ;; (* need access to parser's token definitions *)

  let create_hashtable size init =
    let tbl = Hashtbl.create size in
    List.iter (fun (key, data) -> Hashtbl.add tbl key data) init;
    tbl

  let keyword_table = 
    create_hashtable 8 [
		       ("if", IF);
		       ("in", IN);
		       ("then", THEN);
		       ("else", ELSE);
		       ("let", LET);
		       ("raise", RAISE);
		       ("rec", REC);
		       ("true", TRUE);
		       ("false", FALSE);
		       ("lambda", FUNCTION);
		       ("fun", FUNCTION);
		       ("function", FUNCTION)
		     ]
		     
  let sym_table = 
    create_hashtable 8 [
		       ("=", EQUALS);
		       ("<", LESSTHAN);
		       (".", DOT);
		       ("->", DOT);
		       (";;", EOF);
		       ("~", NEG);
		       ("+", PLUS);
		       ("-", MINUS);
		       ("*", TIMES);
		       ("/", DIV);
		       ("(", OPEN);
		       (")", CLOSE);
		       ("^", CONCAT);
		       ("~.", FNEG);
		       ("+.", FPLUS);
		       ("-.", FMINUS);
		       ("*.", FTIMES);
		       ("/.", FDIV);
		       ("\"", QUOTE);
		       ("()", UNIT);
		       ("[", L_BRACK);
			   ("]", R_BRACK);
			   (";", SEP);
			   ("::",CONS);
			   ("@",LCONCAT);
		     ]
}

let digit = ['0'-'9']
let id = ['a'-'z'] ['a'-'z' '0'-'9']*
let sym = ['(' ')'] | ['"'] | ['[' ']'] | (['+' '-' '*' '.' '=' '~' ';' '<' '>' '^' '/' ':' '@']+)
let unit = '(' ')'
let str = ['a'-'z' 'A'-'Z' '0'-'9' '_'] * 

rule token = parse
  | digit+ as inum
  	{ let num = int_of_string inum in
	  INT num
	}
  | digit+'.' digit * as fnum
    {
    	let num = float_of_string fnum in 
    	FLOAT num 
    }
  | id as word
  	{ try
	    let token = Hashtbl.find keyword_table word in
	    token 
	  with Not_found ->
	    ID word
	}
  | str as letters
  	{ 
  		STRING letters
  	}
  | unit
  	{
  		UNIT
  	}
  | sym as symbol
	{ try
	    let token = Hashtbl.find sym_table symbol in
	    token
	  with Not_found ->
	    token lexbuf
	}
  | '{' [^ '\n']* '}'	{ token lexbuf }    (* skip one-line comments *)
  | [' ' '\t' '\n']	{ token lexbuf }    (* skip whitespace *)
  | _ as c                                  (* warn and skip unrecognized characters *)
  	{ printf "Unrecognized character: %c\n" c;
	  token lexbuf
	}
  | eof
        { raise End_of_file }
