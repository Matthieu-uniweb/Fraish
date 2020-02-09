<html>
<head>
<title>Aide du moteur de recherche</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<div align="center">
  <p><strong><font size="5">Aide du moteur de recherche </font></strong></p>
  <p><strong><font size="5">Administration, Configuration et Statistiques</font></strong></p>
  <p align="left"><font size="4"><strong>Administration, configuration :</strong></font></p>
  <p align="left">Le moteur de recherche donne la possibilit&eacute; &agrave; l&#8217;administrateur
    du site de modifier certaines options.</p>
  <p align="justify">1. Mettre en &eacute;vidence la cha&icirc;ne recherch&eacute;e
    dans les r&eacute;sultats renvoy&eacute;s par le moteur de recherche. <br>
    Cette mise en &eacute;vidence est personnalisable : par l'utilisation d'un
    style CSS : la s&eacute;lection d'une classe CSS permet de modifier par la
    suite dynamiquement la personnalisation en modifiant simplement la feuille
    de style.</p>
  <p align="justify">L&#8217;administrateur peut &eacute;galement choisir de
    mettre dans les r&eacute;sultats le titre de la page ramen&eacute; (balise &laquo; title &raquo;)
    ou la description (balise &laquo; description &raquo;).</p>
  <p align="justify">2. Sp&eacute;cifier le nombre de r&eacute;sultats &agrave; afficher
    par page (par exemple 10).</p>
  <p align="justify">3. Possibilit&eacute; d&#8217;indexer manuellement le site.<br>
    Bouton &laquo; indexer maintenant &raquo;, qui permet de r&eacute;-indexer
    imm&eacute;diatement l&#8217;ensemble du site.</p>
  <p align="justify">Possibilit&eacute; de programmer une indexation. <br>
    Pour cela l&#8217;administrateur doit entrer le mois, le jour et l&#8217;heure &agrave; laquelle
    l&#8217;indexation doit se lancer. <br>
    Le programme va alors g&eacute;n&eacute;rer une nouvelle ligne<strong> &quot;CRON&quot; qui devra &ecirc;tre install&eacute;e sur le serveur</strong>. </p>
  <p align="justify">4. Sp&eacute;cifier les types de fichiers &agrave; indexer
    (par d&eacute;faut il aura les fichiers du type &laquo; .php &raquo;, &laquo; .html &raquo;, &laquo; .htm &raquo;).</p>
  <p align="justify">5. Non indexation des fichiers commen&ccedil;ant par un
    point ou un &laquo; _ &raquo;.</p>
  <p align="justify">6. Un champ o&ugrave; l&#8217;administrateur peut indiquer
    le r&eacute;pertoire racine du site. Une valeur par d&eacute;faut sera entr&eacute;e
    dans ce champ puisque normalement tous les sites ont la m&ecirc;me structure.</p>
  <p align="justify">7. Une partie o&ugrave; l&#8217;utilisateur peut ajouter
    ou supprimer des mots dans la liste de la stoplist.</p>
  <p align="justify">8. D&eacute;cider si il souhaite avoir ou non une table
    de statistiques sur les requ&ecirc;tes, contenant les requ&ecirc;tes tap&eacute;es
    suivant leur nombre en d&eacute;croissant.</p>
  <p align="justify">9. Param&eacute;trer le poids pour les mots pr&eacute;sents
    entre les balises &lt;TITLE&gt; et les mots pr&eacute;sents dans les noms
    de fichiers.</p>
  <p align="justify">10. Possibilit&eacute; d&#8217;indexer tout le contenu des
    pages ou uniquement le nom du fichier et les informations pr&eacute;sentes
    entre les balises &laquo; title &raquo; ou &laquo; description &raquo;. Evidemment
    l&#8217;indexation de tout le contenu est beaucoup plus lente car on ins&egrave;re
    beaucoup plus de mots.</p>
  <p align="justify">11. Trier selon la pertinence (poids) ou la date de cr&eacute;ation
    ou de modification de la page (&agrave; l&#8217;aide de la fonction php &laquo; filemtime &raquo;)</p>
  <p align="justify">12. Inclusion et exclusion de r&eacute;pertoires et fichiers</p>
  <p align="justify">Deux possibilit&eacute;s :<br>
&#8226; Ajouter les r&eacute;pertoires &agrave; exclure dans le champ &laquo; r&eacute;pertoireAExclure &raquo;.<br>
&#8226; Dans chaque page html ou php du site, cr&eacute;er une balise meta &laquo; recherche &raquo; sp&eacute;cifiant
si la page peut &ecirc;tre index&eacute;e ou pas.<br>
    Exemple : &lt;META NAME = &laquo; recherche &raquo; content = &laquo; all &raquo; ou &laquo; none &raquo;&gt;</p>
  <p align="justify">13. En l'&eacute;tat, notre moteur de recherche permet d'indexer
    des informations provenant de pages statiques et dynamiques (avec informations
    provenant de la base de donn&eacute;es). Cependant, il existe encore des
    exceptions qui ne rentrent pas dans ces deux cat&eacute;gories : les pages
    dont les informations proviennent d'un moteur de recherche (et sont donc
    g&eacute;n&eacute;r&eacute;es automatiquement selon le mot cl&eacute;). Pour
    contourner ce probl&egrave;me, nous avons choisi de mettre en place une balise
    meta &quot;urlpagecachee&quot;. L'administrateur va donc cr&eacute;er un
    fichier (le nom importe peu) dans un r&eacute;pertoire qui pourra &ecirc;tre
    index&eacute; par le moteur. Dans ce fichier seront plac&eacute;es les informations
    correspondantes aux pages pr&eacute;cit&eacute;es. Le &quot;content&quot; de
    la balise meta devra contenir l'URL vers laquelle l'administrateur souhaite
    renvoyer ces informations. Ainsi, lorsqu'un mot cl&eacute; correspondra &agrave; un
    mot de cette page, le moteur pr&eacute;sentera l'URL pr&eacute;sent dans
    le &quot;content&quot;.</p>
  <p align="justify">&nbsp;</p>
  <p align="left"><font size="4"><strong>Statistiques :</strong></font></p>
  <p align="left"> L&#8217;administrateur a la possibilit&eacute; de visualiser
    des statistiques sur l&#8217;utilisation du moteur de recherche. <br>
    En effet, lorsqu&#8217;une requ&ecirc;te est tap&eacute;e dans le moteur
    de recherche, elle est directement entr&eacute;e dans la base de donn&eacute;es,
    ainsi que le nombre de fois et la derni&egrave;re date auxquelles elle a &eacute;t&eacute; entr&eacute;e.<br>
    Les liens choisis par l'utilisateur sont &eacute;galement trac&eacute;s et
    entr&eacute;s dans la base de donn&eacute;es..</p>
</div>
<div align="left">
  <p>Dans la partie administration, l&#8217;administrateur peut donc analyser
    les donn&eacute;es selon :</p>
</div>
<ol>
  <li>
    <div align="left"> Les requ&ecirc;tes les plus demand&eacute;es (tri&eacute;es
      selon leur nombre d&#8217;occurrence).</div>
  </li>
  <li>
    <div align="left"> Les requ&ecirc;tes les plus r&eacute;centes (tri&eacute;es
      selon leur date).</div>
  </li>
  <li>
    <div align="left"> Les pages les plus demand&eacute;es (les liens qui ont &eacute;t&eacute; cliqu&eacute;s
      le plus souvent).</div>
  </li>
  <li>
    <div align="left"> Les pages les plus demand&eacute;es selon la requ&ecirc;te
      (pour une requ&ecirc;te donn&eacute;e, quel est le lien qui a &eacute;t&eacute; visit&eacute; le
      plus souvent).</div>
  </li>
</ol>
</body>
</html>
