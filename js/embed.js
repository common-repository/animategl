'use-strict';

window.onload = function () {
	if(window.animateGLInstance) return;

    agl_options = agl_options || []
    agl_options[0] = agl_options[0] || "{}"
    const options = JSON.parse(agl_options[0])
    options.rootFolder = agl_options[1]

    window.animateGLInstance = new AnimateGL(options)
	window.dispatchEvent(new Event('agl-init'))
};






