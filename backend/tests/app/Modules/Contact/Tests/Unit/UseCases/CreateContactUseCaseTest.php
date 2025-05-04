<?php

declare(strict_types=1);

namespace Tests\app\Modules\Contact\Tests\Unit\UseCases;

use Modules\Contact\Application\UseCases\CreateContactUseCase;
use Modules\Contact\Domain\Entities\Contact;
use Modules\Contact\Domain\Repositories\ContactRepositoryInterface;
use Modules\Shared\Domain\Services\GoogleGeocodeGatewayInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Modules\Contact\Domain\ValueObjects\CPF;

class CreateContactUseCaseTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_should_create_contact_when_cpf_not_exists(): void
    {
        $repo = $this->createMock(ContactRepositoryInterface::class);
        $geo  = $this->createMock(GoogleGeocodeGatewayInterface::class);

        $repo->method('findByCpf')->willReturn(null);
        $geo->method('geocode')->willReturn(['lat' => -23.55, 'lng' => -46.63]);

        $repo->method('save')->willReturnCallback(function (Contact $contact) {
            return $contact;
        });

        $useCase = new CreateContactUseCase($repo, $geo);

        $contact = $useCase->execute(
            userId: 1,
            name: 'Paulo',
            cpf: '39053344705',
            phone: '11 9999-9999',
            address: 'Rua Exemplo'
        );

        $this->assertEquals('Paulo', $contact->getName());
        $this->assertEquals(new CPF('39053344705'), $contact->getCpf());
        $this->assertEquals(-23.55, $contact->getLatitude());
    }

    /**
     * @throws Exception
     */
    public function test_should_throw_exception_when_cpf_exists(): void
    {
        $repo = $this->createMock(ContactRepositoryInterface::class);
        $geo  = $this->createMock(GoogleGeocodeGatewayInterface::class);

        $repo->method('findByCpf')->willReturn(new Contact(
            id: 1,
            userId: 1,
            name: 'Paulo',
            cpf: new CPF('39053344705'),
            phone: '11 9999-9999',
            address: 'Rua Exemplo'
        ));

        $useCase = new CreateContactUseCase($repo, $geo);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('ContactModel with this CPF already exists.');

        $useCase->execute(
            userId: 1,
            name: 'Outro',
            cpf: '39053344705',
            phone: '11 9999-9999',
            address: 'Rua Outra'
        );
    }
}
