import { deepMap } from '../../utils/collection';
import { factory } from '../../utils/factory';
var name = 'evaluate';
var dependencies = ['typed', 'parse'];
export var createEvaluate =
/* #__PURE__ */
factory(name, dependencies, function (_ref) {
  var typed = _ref.typed,
      parse = _ref.parse;

  /**
   * Evaluate an expression.
   *
   * Note the evaluating arbitrary expressions may involve security risks,
   * see [https://mathjs.org/docs/expressions/security.html](https://mathjs.org/docs/expressions/security.html) for more information.
   *
   * Syntax:
   *
   *     math.evaluate(expr)
   *     math.evaluate(expr, scope)
   *     math.evaluate([expr1, expr2, expr3, ...])
   *     math.evaluate([expr1, expr2, expr3, ...], scope)
   *
   * Example:
   *
   *     math.evaluate('(2+3)/4')                // 1.25
   *     math.evaluate('sqrt(3^2 + 4^2)')        // 5
   *     math.evaluate('sqrt(-4)')               // 2i
   *     math.evaluate(['a=3', 'b=4', 'a*b'])    // [3, 4, 12]
   *
   *     let scope = {a:3, b:4}
   *     math.evaluate('a * b', scope)           // 12
   *
   * See also:
   *
   *    parse, compile
   *
   * @param {string | string[] | Matrix} expr   The expression to be evaluated
   * @param {Object} [scope]                    Scope to read/write variables
   * @return {*} The result of the expression
   * @throws {Error}
   */
  return typed(name, {
    string: function string(expr) {
      var scope = {};
      return parse(expr).compile().evaluate(scope);
    },
    'string, Object': function stringObject(expr, scope) {
      return parse(expr).compile().evaluate(scope);
    },
    'Array | Matrix': function ArrayMatrix(expr) {
      var scope = {};
      return deepMap(expr, function (entry) {
        return parse(entry).compile().evaluate(scope);
      });
    },
    'Array | Matrix, Object': function ArrayMatrixObject(expr, scope) {
      return deepMap(expr, function (entry) {
        return parse(entry).compile().evaluate(scope);
      });
    }
  });
});