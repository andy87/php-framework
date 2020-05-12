"use strict";

!function init()
{
    console.log( 'Loaded script.js' );

    // а ларчик то просто открывался
    /*console.log(
        (function f(f)
        {
            return typeof f();

        })(function ()
        {
            return 1;
        })
    );*/

    //TODO: учись или лечись! xD
    /*let range = {
        start: 1, end: 10, [Symbol.iterator]() {
            this.current = this.start;
            return this;
        }, next() {
            if (this.current <= this.end) {
                return {done: false, value: this.current++};
            } else {
                return {done: true};
            }
        }
    };
    for (let num of range) {
        alert(num);
    }*/

}();

