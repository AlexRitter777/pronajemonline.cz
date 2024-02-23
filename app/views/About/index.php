<div class="main">


    <div class="about-header">
        <h3>O projektu</h3>
    </div>


   <div class="about-container">

       <div class="about-text">
           <p>Tento projekt představuje komplexní webovou aplikaci pro majitele investičních bytů a rodinných domů. Aplikace nabízí širokou škálu funkcí pro efektivní správu nemovitostí a vztahů mezi pronajímateli a nájemníky. Hlavními funkcemi jsou:</p>

           <ul>
                <li><span>Vyúčtování Služeb spojených s užíváním bytu:</span> Umožňuje vytvořit vyúčtování služeb na základě dat od správce bytového domu, přičemž pronajímatel může vybírat relevantní služby podle zákona nebo nájemní smlouvy. Je vhodné v případě, že je potřeba vyúčtovat poměrnou část služeb za necelý kalendářní rok.</li>

               <li><span>Zjednodušené Vyúčtování Služeb:</span> Vhodné pro případy, kdy nájemník bydlel v nemovitosti celý kalendářní rok a jsou k dispozici data od správce domu.

               <li><span>Vyúčtování Spotřeby Elektřiny:</span> Poskytuje možnost prefakturace nákladů na elektřinu v případě, že nájemník nebyl převeden jako příjemce elektřiny.

               <li><span>Souhrnné Vyúčtování:</span> Slouží k zpracování výsledků z více vyúčtování do jednoho formuláře.

               <li><span>Vyúčtování Kauce:</span> Zabývá se vyúčtováním kauce složené nájemníkem, včetně případných nedoplatků nebo přeplatků.

               <li><span>Univerzální Vyúčtování:</span> Umožňuje prefakturaci nákladů na další utility, jako jsou voda, plyn nebo stočné.
           </ul>

           <p>Aplikace také poskytuje nástroje pro správu nemovitostí, nájemníků, pronajímatelů a dodavatelů elektřiny, včetně možnosti přiřazení nemovitosti k nájemníkovi a pronajímateli. Uživatelé mají možnost ukládat a upravovat vyúčtování, stejně jako uchovávat důležité informace o nemovitosti a kontaktní údaje.</p>
           <p>Aplikace navíc nabízí připomínání důležitých dat, jako je ukončení nájemní smlouvy.</p>
           <p>Tato aplikace je ideálním nástrojem pro efektivní a transparentní správu nemovitostí.</p>

           <div class="about-buttons">
               <button type="button" class="header-top-button">
                   <a href="/applications">Přejít do aplikací</a>
               </button>
               <?php if(!is_user_logged_in()): ?>
                   <button type="button" class="header-top-button">
                       <a href="/user/signup">Založit účet</a>
                   </button>
               <?php endif; ?>
           </div>

       </div>




   </div>

</div>
