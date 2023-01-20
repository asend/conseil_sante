<?php

namespace App\Test\Controller;

use App\Entity\Patient;
use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PatientControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PatientRepository $repository;
    private string $path = '/patient/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Patient::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Patient index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'patient[prenom]' => 'Testing',
            'patient[nom]' => 'Testing',
            'patient[date_naissance]' => 'Testing',
            'patient[lieu_naissance]' => 'Testing',
            'patient[matricule]' => 'Testing',
            'patient[lieu_service]' => 'Testing',
            'patient[date_entree_service]' => 'Testing',
            'patient[nombre_enfant]' => 'Testing',
            'patient[adresse]' => 'Testing',
            'patient[telephone_bureau]' => 'Testing',
            'patient[telephone_personnel]' => 'Testing',
            'patient[situation_matrimoniale]' => 'Testing',
            'patient[tutel]' => 'Testing',
            'patient[corps]' => 'Testing',
        ]);

        self::assertResponseRedirects('/patient/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Patient();
        $fixture->setPrenom('My Title');
        $fixture->setNom('My Title');
        $fixture->setDate_naissance('My Title');
        $fixture->setLieu_naissance('My Title');
        $fixture->setMatricule('My Title');
        $fixture->setLieu_service('My Title');
        $fixture->setDate_entree_service('My Title');
        $fixture->setNombre_enfant('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setTelephone_bureau('My Title');
        $fixture->setTelephone_personnel('My Title');
        $fixture->setSituation_matrimoniale('My Title');
        $fixture->setTutel('My Title');
        $fixture->setCorps('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Patient');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Patient();
        $fixture->setPrenom('My Title');
        $fixture->setNom('My Title');
        $fixture->setDate_naissance('My Title');
        $fixture->setLieu_naissance('My Title');
        $fixture->setMatricule('My Title');
        $fixture->setLieu_service('My Title');
        $fixture->setDate_entree_service('My Title');
        $fixture->setNombre_enfant('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setTelephone_bureau('My Title');
        $fixture->setTelephone_personnel('My Title');
        $fixture->setSituation_matrimoniale('My Title');
        $fixture->setTutel('My Title');
        $fixture->setCorps('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'patient[prenom]' => 'Something New',
            'patient[nom]' => 'Something New',
            'patient[date_naissance]' => 'Something New',
            'patient[lieu_naissance]' => 'Something New',
            'patient[matricule]' => 'Something New',
            'patient[lieu_service]' => 'Something New',
            'patient[date_entree_service]' => 'Something New',
            'patient[nombre_enfant]' => 'Something New',
            'patient[adresse]' => 'Something New',
            'patient[telephone_bureau]' => 'Something New',
            'patient[telephone_personnel]' => 'Something New',
            'patient[situation_matrimoniale]' => 'Something New',
            'patient[tutel]' => 'Something New',
            'patient[corps]' => 'Something New',
        ]);

        self::assertResponseRedirects('/patient/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getDate_naissance());
        self::assertSame('Something New', $fixture[0]->getLieu_naissance());
        self::assertSame('Something New', $fixture[0]->getMatricule());
        self::assertSame('Something New', $fixture[0]->getLieu_service());
        self::assertSame('Something New', $fixture[0]->getDate_entree_service());
        self::assertSame('Something New', $fixture[0]->getNombre_enfant());
        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getTelephone_bureau());
        self::assertSame('Something New', $fixture[0]->getTelephone_personnel());
        self::assertSame('Something New', $fixture[0]->getSituation_matrimoniale());
        self::assertSame('Something New', $fixture[0]->getTutel());
        self::assertSame('Something New', $fixture[0]->getCorps());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Patient();
        $fixture->setPrenom('My Title');
        $fixture->setNom('My Title');
        $fixture->setDate_naissance('My Title');
        $fixture->setLieu_naissance('My Title');
        $fixture->setMatricule('My Title');
        $fixture->setLieu_service('My Title');
        $fixture->setDate_entree_service('My Title');
        $fixture->setNombre_enfant('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setTelephone_bureau('My Title');
        $fixture->setTelephone_personnel('My Title');
        $fixture->setSituation_matrimoniale('My Title');
        $fixture->setTutel('My Title');
        $fixture->setCorps('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/patient/');
    }
}
