open Expr ;;
open Miniml ;;
open Evaluation ;;
open Printf ;;

(******************************* Unit Testing ********************************)
type test = {label: string; content: bool Lazy.t; time:int; fail_msg: string};;

type status = 
  | Passed 
  | Failed of string 
  | Raised_exn of string 
  | Timed_out of int

exception Timeout;;

let sigalrm_handler = 
  Sys.Signal_handle (fun _ -> raise Timeout);;

let timeout (time : int) (delayed : 'a Lazy.t) : 'a = 
  let old_behavior = 
    Sys.signal Sys.sigalrm sigalrm_handler in 
  let reset_sigalrm () = 
    ignore (Unix.alarm 0);
    Sys.set_signal Sys.sigalrm old_behavior in 
  ignore (Unix.alarm time);
  let res = Lazy.force delayed in 
  reset_sigalrm (); res ;;

let present label status = 
  match status with 
  | Passed -> printf "%s: passed\n" label
  | Failed msg -> printf "%s: failed %s\n" label msg
  | Timed_out secs -> printf "%s: timed out in %d\n" label secs
  | Raised_exn msg -> printf "%s: raised %s\n" label msg ;;

let run_test ({label; time; content; fail_msg} : test) 
             (continue : string -> status -> unit) : unit = 
  try 
    if timeout time content
    then continue label Passed
    else continue label (Failed fail_msg)
  with 
  | Timeout -> continue label (Timed_out time)
  | exn     -> continue label (Raised_exn (Printexc.to_string exn ))

let report (tests : test list) : unit = 
  List.iter (fun test -> run_test test present) tests;;

let test ?(fail_msg="something") ?(time=2) label content = 
  {label = label; 
   content = content;
   fail_msg = fail_msg;
   time = time} ;;

(**************************** Exp_to_string tests ****************************)

let exp_to_str_tests = [
  test "Num" (lazy (exp_to_string_AST (str_to_exp "3;;") = "Num(3)"));
  test "Float" (lazy (exp_to_string_AST (str_to_exp "3.2;;") = "Float(3.2)"));
  test "String" (lazy (exp_to_string_AST (str_to_exp "\"aBc\";;")="Str(aBc)"));
  test "Unit" (lazy (exp_to_string_AST (str_to_exp "();;") = "Unit"));
  test "Unit Fun" (lazy (exp_to_string_AST (str_to_exp "fun () -> x;;") = 
                                                           "Fun((), Var(x))"));
  test "Bool" (lazy (exp_to_string_AST (str_to_exp "true;;") = "Bool(true)"));
  test "Var" (lazy (exp_to_string_AST (str_to_exp "x;;") = "Var(x)"));
  test "Unop" (lazy (exp_to_string_AST (str_to_exp "~1;;")="Unop(~, Num(1))"));
  test "Binop 1" (lazy (exp_to_string_AST (str_to_exp "2+3;;") = 
                                                  "Binop(+, Num(2), Num(3))"));
  test "Binop 2" (lazy (exp_to_string_AST (str_to_exp "2 + true;;")= 
                                              "Binop(+, Num(2), Bool(true))"));
  test "Conditional" (lazy (exp_to_string_AST 
   (str_to_exp "if x = 5 then 2 * x else 0;;") = 
   "Conditional(Binop(=, Var(x), Num(5)), Binop(*, Num(2), Var(x)), Num(0))"));
  test "Fun" (lazy (exp_to_string_AST (str_to_exp "fun a -> a + 5;;") = 
                                          "Fun(a, Binop(+, Var(a), Num(5)))"));
  test "Let" (lazy (exp_to_string_AST (str_to_exp "let b = 3 in b + 1;;") = 
                                  "Let(b, Num(3), Binop(+, Var(b), Num(1)))"));
  test "Letrec" (lazy (exp_to_string_AST (str_to_exp "let rec b=3 in b + 1;;")=
                               "Letrec(b, Num(3), Binop(+, Var(b), Num(1)))"));
  test "Raise" (lazy (exp_to_string_AST (str_to_exp "raise;;") = "Raise"));
  test "App" (lazy (exp_to_string_AST (str_to_exp "3 4;;") = 
                                                       "App(Num(3), Num(4))"));
  test "List" (lazy (exp_to_string_AST (str_to_exp "[1;2;3;[4;5;6]];;") = 
           "List([Num(1); Num(2); Num(3); List([Num(4); Num(5); Num(6)])])"));

];;

(****************************** Free_vars tests ******************************)

let free_vars_tests = [
  test "Num" (lazy (free_vars (str_to_exp "3;;") = vars_of_list []));
  test "Float" (lazy (free_vars (str_to_exp "3.2;;") = vars_of_list []));
  test "String" (lazy (free_vars (str_to_exp "\"aBc\";;") = vars_of_list []));
  test "Unit" (lazy (free_vars (str_to_exp "();;") = vars_of_list []));
  test "Var" (lazy (free_vars (Var "x") = vars_of_list(["x"])));
  test "Unop 1" (lazy (free_vars (str_to_exp "~1;;") = vars_of_list []));
  test "Unop 2" (lazy (free_vars (str_to_exp "~x;;") = vars_of_list ["x"]));
  test "Binop 1" (lazy (free_vars (str_to_exp "3+4;;") = vars_of_list []));
  test "Binop 2" (lazy (free_vars (str_to_exp "3+x;;") = vars_of_list ["x"]));
  test "Binop 3" (lazy (free_vars (str_to_exp "x+y;;") = 
                                                      vars_of_list ["x";"y"]));
  test "App" (lazy (free_vars (str_to_exp "f 3;;") = vars_of_list ["f"]));
  test "Conditional" (lazy (free_vars (str_to_exp "if x=5 then 2*x else y;;") =
                                                     vars_of_list ["x"; "y"]));
  test "Fun" (lazy (free_vars (str_to_exp "fun x -> x + y + 3;;") = 
                                                          vars_of_list ["y"]));
  test "Let 1" (lazy (free_vars (str_to_exp "let x = 3 in x;;") =
                                                             vars_of_list []));
  test "Let 2" (lazy (free_vars (str_to_exp "let x = y in x;;") = 
                                                          vars_of_list ["y"]));
  test "Let 3" (lazy (free_vars (str_to_exp "let x = x+x in x;;") = 
                                                          vars_of_list ["x"]));
  test "Let rec 1" (lazy (free_vars 
          (str_to_exp "let rec f = fun x -> f x in f 3;;") = vars_of_list []));
  test "Let rec" (lazy (free_vars 
       (str_to_exp "let rec f = fun x -> f y in f 3;;") = vars_of_list ["y"]));
];;

(***************************** Substitution Tests ****************************)

let repl = Num(3);;
let varname = "x";;

let substitution_tests = [
  test "Same name" (lazy (subst varname repl (Var "x") = Num 3));
  test "Diff name" (lazy (subst varname repl (Var "y") = Var "y" ));
  test "Atomic 1" (lazy (subst varname repl (Num 10) = Num 10));
  test "Atomic 2" (lazy (subst varname repl (Bool true) = Bool true));
  test "Atomic 3" (lazy (subst varname repl (Str "x") = Str "x"));
  test "Unop change" (lazy (subst varname repl (Unop("~",Var "x")) = 
                                                            Unop("~",Num 3)));
  test "Unop no change" (lazy (subst varname repl (Unop("~",Var "y")) =
                                                          Unop("~",Var "y")));
  test "Binop change 1" (lazy (subst varname repl (str_to_exp "12+x;;") = 
                                                         str_to_exp "12+3;;"));
  test "Binop change 2" (lazy (subst varname repl (str_to_exp "y+x;;") = 
                                                          str_to_exp "y+3;;"));
  test "Binop change 3" (lazy (subst varname repl (str_to_exp "y+z;;") = 
                                                          str_to_exp "y+z;;"));
  test "Conditional" (lazy (subst varname repl 
    (str_to_exp "if x = 4 then x + 10 else x - 7;;") = 
       str_to_exp "if 3 = 4 then 3 + 10 else 3 - 7;;"));
  test "Func 1" (lazy (subst varname repl (str_to_exp "fun x -> x + 10;;") = 
                                              str_to_exp "fun x -> x + 10;;"));
  test "Func 2" (lazy (subst varname repl (str_to_exp "fun y -> x + y;;") = 
                                              str_to_exp "fun y -> 3 + y;;"));
  test "Func 3" (lazy (subst varname (str_to_exp "fun z -> y * z;;") 
    (str_to_exp "fun y -> x y;;") = 
      str_to_exp "fun var0 -> (fun z -> y * z) var0;;"));
  test "Let 1" (lazy (subst varname repl (str_to_exp "let x = 10+x in x;;") =
    str_to_exp "let x = 10 + 3 in x;;")); 
  test "Let 2" (lazy (subst varname repl (str_to_exp "let y = x+10 in x+y;;") =
    str_to_exp "let y = 3 + 10 in 3 + y;;"));
  test "Let 3" (lazy (subst varname (str_to_exp "fun z -> y * z;;") 
    (str_to_exp "let y = x 3 in y + 4;;") = 
      str_to_exp "let var1 = (fun z -> y * z) 3 in y + 4;;"));
  test "Letrec 1" (lazy (subst varname repl 
   (str_to_exp "let rec x = 10 * x in x;;") = 
     str_to_exp "let rec x = 10 * x in x;;"));
  test "Letrec 2" (lazy (subst varname repl 
  (str_to_exp "let rec y =fun z -> if z=0 then 1 else x*z*y (z-1) in y 4;;") =
  (str_to_exp "let rec y =fun z -> if z=0 then 1 else 3*z*y (z-1) in y 4;;")));
  test "Letrec 3" (lazy (subst varname (str_to_exp "fun z -> y * z;;")
   (str_to_exp "let rec y = y x 3 in y + 4;;") = 
    str_to_exp "let rec var2 = var2 (fun z -> y * z) 3 in y + 4;;"));
  test "App" (lazy (subst varname repl (str_to_exp "y x;;") = 
    App(Var "y", Num 3)));
  test "List" (lazy (subst varname repl (str_to_exp "[x;x+10;x/2];;") = 
    str_to_exp "[3;3+10;3/2];;"))
];;

(******************************* Eval_s Tests *******************************)
let env = Env.create () ;;
let wrap x= Env.Val(x);;
let dummy = wrap Unit;;

let evaluate eval = [
 test "Num" (lazy (eval (Num 4) env = wrap (Num 4 )));
 test "Free Var" (lazy (eval (Var "x") env = dummy));
 test "Bool" (lazy (eval (Bool true ) env = wrap (Bool true )));
 test "String" (lazy (eval (Str "aAb_C") env = wrap (Str "aAb_C")));
 test "Num Unop" (lazy (eval (str_to_exp "~1;;") env = wrap (Num (-1))));
 test "Flo Unop" (lazy (eval (str_to_exp "~.1.;;") env= wrap (Float (-1.))));
 test "Num Binop" (lazy (eval (str_to_exp "3 + 4;;") env = wrap (Num 7)));
 test "Num fail Binop" (lazy (eval (str_to_exp "3 @ 4;;") env = dummy));
 test "Bool Binop" (lazy (eval (str_to_exp "true = true;;") env = 
                                                           wrap (Bool true)));
 test "Bool fail Binop" (lazy (eval (str_to_exp "true+true;;") env = dummy));
 test "Str Binop" (lazy (eval (str_to_exp "\"abc\" ^ \"AbC_A\";;") env = 
                                                       wrap (Str "abcAbC_A")));
 test "Str Fail Binop" (lazy (eval (str_to_exp "\"abc\" < \"AbC_A\";;") env =
                                                                       dummy));
 test "List Binop" (lazy (eval (str_to_exp "4::[1;2;3];;") env = 
                                             wrap (str_to_exp "[4;1;2;3];;")));
 test "LConcat Binop" (lazy (eval (str_to_exp "[1;2] @ [4;\"a\";6];;") env = 
                                       wrap (str_to_exp "[1;2;4;\"a\";6];;")));
 test "Fail Binop" (lazy (eval (str_to_exp "[1;2]+3;;") env = dummy));
 test "Conditional 1" (lazy (eval 
   (str_to_exp "if 3 < 4 then 3 else 20;;") env = wrap (Num 3)));
 test "Conditional 2" (lazy (eval 
   (str_to_exp "if 4 < 3 then 4 else 20;;") env = wrap (Num 20)));
 test "Fun" (lazy (eval (str_to_exp "fun x -> x + y;;") env = 
                                        wrap (str_to_exp "fun x -> x + y;;")));
 test "Unit fun" (lazy (eval (str_to_exp "let x = fun () -> 3 in x ();;") env = 
                                                                wrap (Num 3)));
 test "Unit fun fail" (lazy (eval (str_to_exp "let x = fun () -> 3 in x 5;;")  
                                                              env = dummy)); 
 test "App" (lazy (eval (str_to_exp "(fun x -> 3 * x) 10;;") env = 
                                                               wrap (Num 30)));
 test "App Fail" (lazy (eval (str_to_exp "4 10;;") env = dummy));
 test "Let 1" (lazy (eval (str_to_exp "let x = 3 in x + x;;") env = 
                                                                wrap (Num 6)));
 test "Let 2" (lazy (eval (str_to_exp "let x = 3 in let x = x + 1 in x*10;;")
                                                         env = wrap (Num 40)));
 test "Let 3" (lazy (eval (str_to_exp "let x = 3 in let y = 10 in x + y;;")
                                                         env = wrap (Num 13)));
 test "Let fun" (lazy (eval (str_to_exp "let x = fun y -> y + 1 in x 10;;") 
                                                         env = wrap (Num 11)));
 test "Fail let" (lazy (eval (str_to_exp "let x = x+3 in x;;") env = dummy));
 test "Let rec 1" (lazy (eval 
  (str_to_exp ("let rec f = " ^
                 "fun x -> if x = 0  then 1 else x * f (x - 1) " ^     
               "in f 3;;")) env = wrap (Num 6))); 
 test "Let rec 2; fails with eval_d" (lazy (eval 
  (str_to_exp ("let rec fib = fun n -> fun x -> fun y -> " ^
                             "if n = 0 then x else fib  (n - 1) y (x + y) " ^
                             "in fib 10 0 1;;")) env = wrap (Num 55)));
 test "Let rec 3; fails with eval_d" (lazy (eval 
  (str_to_exp ("let fib = fun n -> " ^ 
                 "let rec fib = " ^ 
                   "fun n -> fun x -> fun y -> " ^ 
                     "if n = 0 then x  else fib  (n - 1) y (x + y) " ^ 
                 "in fib n 0 1 " ^ 
               "in fib 10;;")) env = wrap (Num 55)));
 test "Looping recursion" (lazy (eval 
   (str_to_exp "let rec f = fun x -> f x in f 3;;") env = dummy));
 test "List" (lazy (eval (str_to_exp ("[1 + 2; 3.0 +. 4.8; [10 / 4]; " ^ 
             "let rec f = fun x -> if x = 0  then 1 else x * f (x - 1) " ^     
             "in f 3; true = false];;")) env = 
             wrap (str_to_exp "[3; 7.8; [2]; 6; false];;")));
 test "Passes only in eval_s" (lazy (eval 
  (str_to_exp ("let x = 1 in let f = fun y -> x + y in " ^ 
               "let x = 2 in f 3;;")) env = wrap (Num 4)));
 test "Passes only in eval_d" (lazy (eval 
  (str_to_exp ("let x = 1 in let f = fun y -> x + y in " ^ 
               "let x = 2 in f 3;;")) env = wrap (Num 5)));
] ;;

let eval_s_tests = evaluate eval_s;;
let eval_d_tests = evaluate eval_d;;

(******************************** Run Tests *********************************)

let all_tests = [("Exp_to_str",exp_to_str_tests);
            ("Free_vars", free_vars_tests);
             ("Substitution",substitution_tests);
             ("Eval_s", eval_s_tests);
             ("Eval_d", eval_d_tests)
             ];;
List.iter (fun (name,lst) -> printf "\n%s\n" name; report lst) all_tests;;

