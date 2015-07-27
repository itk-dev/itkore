SVG converter: http://www.mobilefish.com/services/image2svg/image2svg.php
Uses an image tag which is not really possible to manipulate.

Fireworks has an export extension that outputs a proper svg structure, but has a tendecy to link to an external png image.

Afterwards convert the svg to a twig template.

Use {% include 'file' %} To add the svg file from a twig template.

Example:
{% include 'sites/all/themes/itkore/templates/menu-image.html.twig' %}