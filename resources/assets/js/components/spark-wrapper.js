const Spark = require('spark');

class SparkWrapper {
  static getVueRouterModule() {
    return Object.entries(Spark).reduce(
      (collection, [key, value]) => {
        // explicitly convert 'data' and 'el' attributes to functions
        if (['data', 'el'].includes(key)) {
          collection[key] = () => value
        } else {
          // and keep everything else as it is
          collection[key] = value
        }

        return collection
    }, {})
  }
}
// Use the static method of our new SparkWrapper-class,
// to get the sparking vue-router ready object.
module.exports = SparkWrapper.getVueRouterModule();