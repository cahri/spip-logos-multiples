# spip-logos-multiples

Ce plugin pour SPIP permet d’avoir plus de deux logos par objet éditorial. Mon cas d’usage est de permettre de mettre un logo desktop, un logo tablette et un logo mobile pour les sites adaptatifs.

Dans la configuration du plugin, vous indiquez le nom du logo ainsi que le label correspondant, par ex :

```
tablet|Logo pour tablette
mobile|Logo pour mobile
```

Ensuite, dans vos squelettes, vous pourrez utiliser `#LOGO_ARTICLE_TABLET` et `#LOGO_ARTICLE_MOBILE`.

## Crédits

La gestion des balises `#LOGO_` a été reprise du core de SPIP avec une légère adaptation.