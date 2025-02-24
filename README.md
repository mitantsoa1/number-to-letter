# NumberToLetter

[![PHP Version](https://img.shields.io/badge/PHP-%3E=8.0-blue)](https://www.php.net/)  
Une bibliothèque PHP permettant de convertir des nombres en lettres avec gestion des devises.

---

## 🚀 Installation

Utilisez **Composer** pour installer le package dans votre projet :

```sh
composer require mitantsoa/number-to-letter

---
###  Usage

$converter = new NumberToLetter();
echo $converter->convertNumberToLetter(1250.75, 'Euro');
===> "Mille deux cent cinquante Euro soixante-quinze"
```
