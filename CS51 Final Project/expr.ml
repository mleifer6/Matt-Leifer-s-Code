
(** Abstract syntax of MiniML expressions *)

type expr =
  | Var of varid                         (* variables *)
  | Num of int                           (* integers *)
  | Bool of bool                         (* booleans *)
  | Unop of varid * expr                 (* unary operators *)
  | Binop of varid * expr * expr         (* binary operators *)
  | Conditional of expr * expr * expr    (* if then else *)
  | Fun of varid * expr                  (* function definitions *)
  | Let of varid * expr * expr           (* local naming *)
  | Letrec of varid * expr * expr        (* recursive local naming *)
  | Raise                                (* exceptions *)
  | Unassigned                           (* (temporarily) unassigned *)
  | App of expr * expr                   (* function applications *)
  | Str of string
  | Float of float
  | Unit 
  | List of expr list
 and varid = string ;;
  
(** Sets of varids *)
module SS = Set.Make(struct
		      type t = varid
		      let compare = String.compare
		    end);;
  
type varidset = SS.t ;;

(** Test to see if two sets have the same elements (for
    testing purposes) *)
let same_vars = SS.equal;;

(** Generate a set of variable names from a list of strings (for
    testing purposes) *)
let vars_of_list = SS.of_list ;;
  
(** Return a set of the variable names free in [exp] *)
(* Num, bool, raise and unassigned have no free vars *)
let rec free_vars (exp : expr) : varidset =
  match exp with 
  | Var x -> SS.singleton x
  | Num _ | Bool _ | Str _ | Float _ | Unit | Raise | Unassigned -> SS.empty
  | Unop(_, e) -> free_vars e 
  | Binop(_, e1, e2) | App(e1, e2) -> SS.union (free_vars e1) (free_vars e2)
  | Conditional(e1,e2,e3) -> (SS.union (free_vars e1) 
                                      (SS.union (free_vars e2) (free_vars e3)))
  | Fun(x, e) -> SS.diff (free_vars e) (SS.singleton x)
  | Let(x, e1, e2) -> SS.union (free_vars e1) 
                                      (SS.diff (free_vars e2) (SS.singleton x))
  | Letrec(x, e1, e2) -> SS.union (SS.diff (free_vars e1) (SS.singleton x))
                                  (SS.diff (free_vars e2) (SS.singleton x))
  | List(exp_list) -> List.fold_right (fun x acc -> SS.union acc (free_vars x))
                      exp_list SS.empty 

(** Return a fresh variable, constructed with a running counter a la
    gensym. Assumes no variable names use the prefix "var". *)
let new_varname =
  let inc = 
    let ctr = ref (-1) in 
    fun () -> (ctr := !ctr + 1; !ctr) in 
  fun () -> "var" ^ (string_of_int (inc () )) ;;
  
(** Substitute [repl] for free occurrences of [var_name] in [exp] *)
(* Subsitute all free occurences of [var_name] in [exp] with [repl] *)
let rec subst (var_name: varid) (repl: expr) (exp: expr) : expr =
  match exp with 
  | Var y -> if y = var_name then repl else exp
  | Num _ | Bool _ | Str _ | Float _ | Unit | Raise | Unassigned -> exp
  | Unop(u, e) -> Unop(u, subst var_name repl e)
  | Binop(b, e1, e2)-> Binop(b, subst var_name repl e1, subst var_name repl e2)
  | Conditional(e1,e2,e3) -> Conditional(subst var_name repl e1, 
                             subst var_name repl e2, subst var_name repl e3)
  | Fun(y, e) -> if y = var_name then exp 
                 else if not (SS.mem y (free_vars repl)) then
                   Fun(y, subst var_name repl e)
                 else 
                   let z = new_varname () in 
                   let new_ex = subst y (Var z) e in 
                   Fun(z, subst var_name repl new_ex)
  | Let(y, e1, e2) -> if y = var_name then Let(y, subst var_name repl e1, e2)
                      else if not (SS.mem y (free_vars repl)) then 
                        Let(y, subst var_name repl e1, subst var_name repl e2)
                      else
                        let z = new_varname () in
                        let new_ex = subst y (Var z) e1 in 
                        Let(z, subst var_name repl new_ex, 
                            subst var_name repl e2)
  | Letrec(y, e1, e2) -> if y = var_name then exp 
                         else if not (SS.mem y (free_vars repl)) then 
                           Letrec(y, subst var_name repl e1, 
                                  subst var_name repl e2)
                         else
                          let z = new_varname () in
                          let new_ex = subst y (Var z) e1 in 
                          Letrec(z, subst var_name repl new_ex, 
                                 subst var_name repl e2)
  | App(e1, e2) -> App (subst var_name repl e1, subst var_name repl e2)
  | List(exp_list) -> List(List.fold_right (fun e acc -> 
                                  (subst var_name repl e)::acc) exp_list []) ;;



(** Returns a string representation of the expr *)

let rec print_list to_string (lst : expr list) = 
    match lst with 
    | [] -> ""
    | [e] -> to_string e 
    | e::t -> (to_string e) ^ "; " ^ (print_list to_string t) ;;

let rec exp_to_string_AST (exp: expr) : string = 
  match exp with 
  | Var v -> "Var(" ^ v ^ ")"
  | Num n -> "Num(" ^ string_of_int n ^ ")" 
  | Bool b -> if b then "Bool(true)" else "Bool(false)"
  | Str s -> "Str(" ^ s ^ ")"
  | Float f -> "Float(" ^ string_of_float f ^ ")"
  | Unit -> "Unit"
  | Unop(u, e) -> "Unop(" ^ u ^ ", " ^ exp_to_string_AST e ^ ")"
  | Binop(b, e1, e2) -> "Binop(" ^ b ^ ", " ^ exp_to_string_AST e1 ^ ", "  ^
                         exp_to_string_AST e2 ^ ")"
  | Conditional(e1, e2, e3) -> "Conditional(" ^ exp_to_string_AST e1 ^ ", " ^ 
                               exp_to_string_AST e2 ^ ", " ^ 
                              exp_to_string_AST e3 ^ ")"
  | Fun(v, e) -> "Fun(" ^ v ^ ", " ^ exp_to_string_AST e ^ ")"
  | Let(v, e1, e2) -> "Let(" ^ v ^ ", " ^ exp_to_string_AST e1 ^ ", " ^
                      exp_to_string_AST e2 ^ ")"
  | Letrec(v, e1, e2) -> "Letrec(" ^ v ^ ", " ^ exp_to_string_AST e1 ^ ", " ^
                         exp_to_string_AST e2 ^ ")"
  | Raise -> "Raise"
  | Unassigned -> "Unassigned"
  | App(e1, e2) -> "App(" ^ exp_to_string_AST e1 ^", "^exp_to_string_AST e2^")"
  | List(e_list) -> "List([" ^ (print_list exp_to_string_AST e_list) ^ "])" ;;


let rec exp_to_string_CON (exp: expr) : string =
  match exp with 
  | Var v -> v
  | Num n -> string_of_int n
  | Bool b -> if b then "true" else "false"
  | Str s -> "\"" ^ s ^ "\""
  | Float f -> string_of_float f
  | Unit -> "()"
  | Unop(u, e) -> u ^ exp_to_string_CON e
  | Binop(b, e1, e2) -> exp_to_string_CON e1 ^ " " ^ b ^ " " ^ 
                        exp_to_string_CON e2
  | Conditional(e1, e2, e3) -> "if " ^ exp_to_string_CON e1 ^ " then " ^
                         exp_to_string_CON e2 ^ " else " ^ exp_to_string_CON e3
  | Fun(v, e) -> "(fun " ^ v ^ " -> " ^ exp_to_string_CON e ^ ")"
  | Let(v, e1, e2) -> "let " ^ v ^ " = " ^ exp_to_string_CON e1 ^ " in " ^
                      exp_to_string_CON e2
  | Letrec(v, e1, e2) -> "let rec" ^ v ^ " = " ^ exp_to_string_CON e1 ^ " in "
                         ^ exp_to_string_CON e2
  | Raise -> "Raise"
  | Unassigned -> "Unassigned"
  | App(e1, e2) -> exp_to_string_CON e1 ^ " " ^ exp_to_string_CON e2
  | List(e_list) -> "[" ^ (print_list exp_to_string_CON e_list) ^ "]" ;;

let exp_to_string = exp_to_string_CON;;

let all_vars (exp : expr) : varid list = 
  let rec all_vars_aux exp lst = 
  match exp with 
  | Num _ | Bool _  | Str _ | Float _ | Unit | List _ -> lst
  | Var v -> v :: lst
  | Unop(_, e) -> all_vars_aux e lst
  | Binop(_, e1, e2) | App(e1, e2) -> (all_vars_aux e1 lst) @ 
                                       (all_vars_aux e2 lst)
  | Conditional(e1, e2, e3) ->  (all_vars_aux e1 lst) @ (all_vars_aux e2 lst) @
                                                        (all_vars_aux e3 lst)
  | Fun(v, e) -> v :: (all_vars_aux e lst)
  | Let(v, e1, e2) | Letrec(v, e1, e2) ->  v :: (all_vars_aux e1 lst) @ 
                                                (all_vars_aux e2 lst) 
  | Raise -> lst
  | Unassigned -> lst
in all_vars_aux exp [] ;;

