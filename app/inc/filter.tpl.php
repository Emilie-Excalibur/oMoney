<form method="get" action="">
    <div class="mb-2 d-flex align-items-center">
        <label class="mr-sm-2" for="filter">Trier par</label>
        <div class="col-auto my-1">
            <select class="custom-select mr-sm-2" id="filter" name="filter">
                <option value="all">Tout afficher</option>
                <option value="date">Le plus récent</option>
                <option value="today">Aujourd'hui</option>
                <option value="yesterday">Hier</option>
                <option value="week">Cette semaine</option>
                <option value="month">Ce mois</option>
                <option value="title">Ordre alphabétique</option>
                <option value="sum">Somme dépensée</option>
            </select>
        </div>
        <button type="submit" class="btn btn-info">Valider</button>
    </div>
</form>

<table class="table table-striped text-center">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Intitulé</th>
                <th scope="col">Somme dépensée</th>
                <th scope="col">Virement</th>
            </tr>
        </thead>
        <tbody>


