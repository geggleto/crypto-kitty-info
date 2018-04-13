

# This Query finds all kittys with a diamond jewel
`select  id from kitties where JSON_CONTAINS(kitty->"$.enhanced_cattributes[*].position", '1') = 1 LIMIT 25;`
